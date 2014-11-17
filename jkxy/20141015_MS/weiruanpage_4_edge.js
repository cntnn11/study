var screen_width	= $(document.body).outerWidth(true);
var image_x			= (screen_width)/2-16+70;
var image2_x		= (screen_width-384*2)/2+70;
var image3_x		= (screen_width-221)/2;
var logo_x			= (screen_width-254)/2;
var rectang_x		= (screen_width-153)/2;
var ellipse_l_x		= (screen_width-192*2)/2;
var ellipse_r_x		= (screen_width)/2+190;
(function(compId) {
	"use strict";
	var _ = null,
	y = true,
	n = false,
	x10 = 'rgba(255,255,255,0.00)',
	x1 = '5.0.0',
	e17 = '${logo}',
	x3 = 'rgba(0,0,0,0)',
	lf = 'left',
	g = 'image',
	e12 = '${Image2}',
	b = 'block',
	e16 = '${Image3}',
	zx = 'scaleX',
	e14 = '${Rectangle}',
	o = 'opacity',
	e15 = '${Image}',
	e13 = '${EllipseCopy}',
	tp = 'top',
	x2 = '5.0.0.375',
	x9 = 'rgba(255,255,255,1)',
	m = 'rect',
	x6 = 'rgba(255,255,255,1.00)',
	d = 'display',
	xc = 'rgba(0,0,0,1)',
	e11 = '${Ellipse}',
	i = 'none';
	var g5 = 'banner_jkxy.png?20141020a',
	g8 = 'banner_hezuo.png?20141020a',
	g4 = 'banner_mva.png?20141020a',
	g7 = 'logo.png?20141020a';
	var im = 'http://static-jkxy.qiniudn.com/ms/',
	aud = 'media/',
	vid = 'media/',
	js = 'js/',
	fonts = {},
	opts = {
		'gAudioPreloadPreference': 'auto',
		'gVideoPreloadPreference': 'auto'
	},
	resources = [],
	scripts = [],
	symbols = {
		"stage": {
			v: x1,
			mv: x1,
			b: x2,
			stf: i,
			cg: i,
			rI: n,
			cn: {
				dom: [{
					id: 'Image',
					t: g,
					r: [image_x, '93px', '384px', '60px', 'auto', 'auto'],
					o: 0,
					f: [x3, im + g4, '0px', '0px']
				},
				{
					id: 'Image2',
					t: g,
					r: [image2_x, '95px', '266px', '60px', 'auto', 'auto'],
					o: 0,
					f: [x3, im + g5, '0px', '0px']
				},
				{
					id: 'Rectangle',
					v: i,
					t: m,
					r: [rectang_x, '255px', '153px', '1px', 'auto', 'auto'],
					o: 1,
					f: [x6],
					s: [0, xc, i],
					tf: [[], [], [], ['2.49']]
				},
				{
					id: 'logo',
					t: g,
					r: [logo_x, '248px', '254px', '44px', 'auto', 'auto'],
					o: 0,
					f: [x3, im + g7, '0px', '0px']
				},
				{
					id: 'Image3',
					t: g,
					r: [image3_x, '208px', '221px', '39px', 'auto', 'auto'],
					o: 0,
					f: [x3, im + g8, '0px', '0px']
				},
				{
					id: 'Ellipse',
					v: i,
					t: 'ellipse',
					r: [ellipse_l_x, '253px', '5px', '5px', 'auto', 'auto'],
					br: ["50%", "50%", "50%", "50% 50%"],
					f: [x9],
					s: [0, "rgb(0, 0, 0)", i]
				},
				{
					id: 'EllipseCopy',
					v: i,
					t: 'ellipse',
					r: [ellipse_r_x, '253px', '5px', '5px', 'auto', 'auto'],
					br: ["50%", "50%", "50%", "50% 50%"],
					f: [x9],
					s: [0, "rgb(0, 0, 0)", i]
				}],
				style: {
					'${Stage}': {
						isStage: true,
						r: [undefined, undefined, screen_width, '350px'],
						overflow: 'hidden',
						f: [x10]
					}
				}
			},
			tt: {
				d: 2044,
				a: y,
				data: [["eid44", d, 1544, 0, "easeOutBounce", e11, i, b], ["eid4", tp, 0, 1000, "easeInOutElastic", e12, '95px', '94px'], ["eid43", d, 1544, 0, "easeOutBounce", e13, i, b], ["eid29", d, 1544, 0, "easeOutQuad", e14, i, b], ["eid2", lf, 0, 1000, "easeInOutElastic", e12, '0px', image_x], ["eid6", lf, 0, 1000, "easeInOutElastic", e15, '1416px', image2_x], ["eid8", tp, 0, 1000, "easeInOutElastic", e15, '93px', '94px'], ["eid12", o, 0, 1000, "easeInOutElastic", e15, '0', '1'], ["eid40", lf, 1544, 500, "easeOutBounce", e11, '897px', ellipse_l_x], ["eid14", zx, 1544, 500, "easeOutBounce", e14, '0.01', '2.49'], ["eid10", o, 0, 1000, "easeInOutElastic", e12, '0', '1'], ["eid42", lf, 1544, 500, "easeOutBounce", e13, '899px', ellipse_r_x], ["eid31", tp, 1000, 544, "easeOutQuad", e16, '208px', '178px'], ["eid18", o, 1544, 500, "easeOutQuad", e17, '0', '1'], ["eid16", tp, 1544, 500, "easeOutQuad", e17, '248px', '284px'], ["eid33", o, 1000, 544, "easeOutQuad", e16, '0', '1']]
			}
		}
	};
	AdobeEdge.registerCompositionDefn(compId, symbols, fonts, scripts, resources, opts);
})("EDGE-841347746"); (function($, Edge, compId) {
	var Composition = Edge.Composition,
	Symbol = Edge.Symbol;
	Edge.registerEventBinding(compId,
	function($) {
		//Edge symbol: 'stage'
		(function(symbolName) {})("stage");
		//Edge symbol end:'stage'
	})
})(AdobeEdge.$, AdobeEdge, "EDGE-841347746");