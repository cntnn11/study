foreach ($lists as $orderId => $row)
{
	if( !empty($row[1]) )
	{
		// 判断下当前这个订单是否已发货，发货的就不能拆单了
		$orderRet	= $this->client->call('order', 'getOrderInfoById', ['orderId'=>$orderId]);
		if( empty($orderRet['data']) )
		{
			DLog::trace("procurement split stockFlow: order:getOrderInfoById, result: " . json_encode($orderRet) );
			continue;
		}
		$orderInfo	= $orderRet['data'];
		if( $orderInfo['expressStatus'] > 10 )
		{
			DLog::trace("procurement split stockFlow: order:getOrderInfoById, result: 订单`{$orderId}` 已发货，不允许拆单！ expressStatus=" . $orderInfo['expressStatus'] );
			continue;
		}

		// 同一个订单内进行拆单动作
		$orderItemIdsReq= [
			"conds"	=> [
				"stat"		=> 0,
				"orderId"	=> $orderId,
			]
		];
		$orderItemIds	= $this->client->call('order', 'getOrderItemByConds', $orderItemIdsReq);
		DLog::trace("procurement split stockFlow: order:getOrderItemByConds, param: " . json_encode($orderItemIdsReq) . " result:" . json_encode($orderItemIds) );
		if( empty($orderItemIds['data']) )
		{
			continue;
		}

		$idLists	= [];
		foreach ($orderItemIds['data'] as $orderItemInfo)
		{
			if( !empty($row[0]['ids']) )
			{
				if( in_array($orderItemInfo['procureItemId'], $row[0]['ids']) )
				{
					$idLists[0][]	= $orderItemInfo['id'];
				}
			}
			if( in_array($orderItemInfo['procureItemId'], $row[1]['ids']) )
			{
				$idLists[1][]	= $orderItemInfo['id'];
			}
		}

        // 拆单动作
		$splitOrderReq	= [
			'orderId'		=> $orderId,
			'allItemList'	=> $idLists,
			'other'			=> [],
		];
		$splitOrderRet	= $this->client->call('order', 'handlerChildOrder', $splitOrderReq);
		//error_log( 'handlerChildOrder splitOrderRet -> '. json_encode($splitOrderRet) . "\n", 3, "/tmp/tempdata.log" );

		DLog::trace("procurement split stockFlow: order:handlerChildOrder, param:" . json_encode($splitOrderReq) . " result:" . json_encode($splitOrderRet) );
		if( empty($splitOrderRet['item']) || empty($splitOrderRet['order']) )
		{
			continue;
		}

		// 拆分采购单，获取拆新订单之后的新的订单ID，用它关联入库单、出库单。
		$procureIdStr	= implode("','", $row[1]['ids']);
		$orderItemListsReq	= [
			"conds"	=> [
				"stat"	=> 0,
				"`procureItemId` IN ('{$procureIdStr}') ",
			],
			"appends"	=> [
				" ORDER BY `id` DESC ",
				" LIMIT 1 "
			],
		];

        // 将拆分完并且已入库的采购单商品，生成一张入库单
		$orderItemListsRet	= $this->client->call("order", "getOrderItemByConds", $orderItemListsReq);
		DLog::trace("procurement split stockFlow: getOrderItemByConds, param: " . json_encode($orderItemListsReq) . " result: " . json_encode($orderItemListsRet));
		if( empty($orderItemListsRet['data'][0]['orderId']) )
		{
			continue;
		}
		$newOrderId			= $orderItemListsRet['data'][0]['orderId'];
		$skuIds				= $row[1]['skuIds'];
        $procureItemIds		= $row[1]['ids'];
		$splitPrcureReq		= [
			"procureId"	=> $procureId,
			"orderId"	=> $newOrderId,
			"ids"		=> $procureItemIds,
			"other"		=> [
				'warehouseId'	=> $warehouseId,
				'expressId'		=> $expressId,
				'expressNo'		=> $expressNo,
			],
		];

		$splitPrcureRet		= $this->client->call("order", "mergeProcureItemToNewStock", $splitPrcureReq);
		DLog::trace("procurement split stockFlow: mergeProcureItemToNewStock, param: " . json_encode($splitPrcureReq) . " result: " . json_encode($splitPrcureRet));
        // 删除旧子订单关联的入库单、出库单数据以及该子订单关联的入库和出库单的商品数据
        $stockFlowReq   = [
            "conds" => [
                "orderId"   => $orderId,
            ],
        ];
        $upd    = $this->client->call("order", "deleteStockFlowByConds", $stockFlowReq);

		// 更新新的订单号为已发货状态
		$updNewOrderReq	= [
			'data'		=> [
				'expressStatus'	=> 20,
				'stepStatus'	=> 30,
			],
			'orderId'	=> $newOrderId,
		];
		$ret = $this->client->call("order", "updateOrderById", $updNewOrderReq);
		DLog::trace("procurement split stockFlow: updateOrderById, param: " . json_encode($updNewOrderReq) . " result: " . json_encode($ret));

		// 统计当前采购单下的商品是否都已拆分完（判断是否生成了入库单），如果采购单商品数量和入库单中item表中数量一致，那么说明已拆完，需将采购单改为“官网已发货”状态
        $procureItemIdsReq  = [
            'conds' => [
                'stat'      => 0,
                'procureId' => $procureId,
            ],
        ];
        $procureItemIdsRet  = $this->client->call('order', 'getProcurementItemByConds', $procureItemIdsReq);
        if( !empty($procureItemIdsRet['data']) )
        {
            foreach ($procureItemIdsRet['data'] as $procureItemInfo)
            {
                $procureItemIds[$procureItemInfo['id']] = $procureItemInfo['id'];
            }
            $stockFlowItemReq   = [
                'conds' => [
                    'stat'  => 0,
                    " `procureItemId` IN ('" . implode("','", $procureItemIds) . "') ",
                ],
            ];
            $stockFlowItemRet   = $this->client->call('order', 'getStockFlowItemCountByConds', $stockFlowItemReq);
            $stockFlowItemTotal = !empty($stockFlowItemRet['data']) ? $stockFlowItemRet['data']/2 : 0;
            DLog::trace("procurement count split: getStockFlowItemCountByConds, param: " . json_encode($stockFlowItemReq) . " result: " . json_encode($stockFlowItemRet));
            if( !empty($procureItemIds) && !empty($stockFlowItemTotal) && count($procureItemIds) == $stockFlowItemTotal )
            {
                // 修改当前采购单的状态为官网已发货
                $updReq = array(
                    'procureId' => $procureId,
                    'event'     => 'SUPPLIER_SEND',//入库完成
                    'param'     => array(),
                );
                $updRet = $this->client->call("order","updateProcurementStatus",$updReq);
                DLog::trace("procurement count split: updateProcurementStatus, param: " . json_encode($updReq) . " result: " . json_encode($updRet));
            }
        }

	}
}
