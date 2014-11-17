    //调试开关
    var debug = false;
    var documentdomain = false;
    if(documentdomain) document.domain = "tcsasac.com";

    if(debug){
        if(typeof(console) == 'undefined'){
            console = {log :alert};
        };
    }else{
        if(typeof(console) == 'undefined'){
            console = {log : function(){}};
        }else{
            console.log = function(){};
        };
    };

    //提示信息控制
    infoSys = {
        'display':function(info,time){
            var _self = this;
            clearTimeout(this.setTimeout);
            this.getDom().setStyle('display','').innerHTML = info || '';
            if(time){
                this.setTimeout = setTimeout(function(){
                    _self.getDom().setStyle('display','none');
                },time);
            };
        },
        'error':function(info,time){
            this.getDom().removeClass('warnInfo').removeClass('rightInfo').addClass('wrongInfo');
            this.display(info,time);
        },
        'alert':function(info,time){
            this.getDom().removeClass('wrongInfo').removeClass('rightInfo').addClass('warnInfo');
            this.display(info,time);
        },
        'info':function(info,time){
            this.getDom().removeClass('warnInfo').removeClass('wrongInfo').addClass('rightInfo');
            this.display(info,time);
        },
        'getDom':function(){
            if(!this.targetDom) this.targetDom = $('sysInfo');
            return this.targetDom;
        }
    }

Login = {
    validate : function(){
        var username = $('username').get('value').trim();
        var usernameEl = $('username');
        if(username.length == 0){
            infoSys.error('请填写登录账号');
            usernameEl.focus();
            return false;
        };

        var checkMailFormat = true;
        for(var key in this.prefixReg){
            if(new RegExp(key).test(username)){
                checkMailFormat = false;
                break;
            };
        };

        if(checkMailFormat){
            if(!/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(username)){
                infoSys.error('请正确的登录账号格式');
                usernameEl.focus();
                return false;
            };
        };

        if(username.length  > 50){
            infoSys.error('登录账号不超过50个字符');
            usernameEl.focus();
            return false;
        };

        var password = $('password').get('value');
        var passwordEl = $('password');
        if(password.length == 0){
            infoSys.error('请填写登录密码');
            passwordEl.focus();
            return false;
        };

        if(password.length  > 20){
            infoSys.error('登录密码不超过20个字符');
            passwordEl.focus();
            return false;
        };

        var vcode = $('vcode').get('value').trim();
        var vcodeEl = $('vcode');
        if(vcode.length == 0){
            infoSys.error('请填写验证码');
            vcodeEl.focus();
            return false;
        };

        if(vcode.length  > 0){
            if(!/^.{4}$/.test(vcode)){
                infoSys.error('验证码应为4位');
                vcodeEl.focus();
                return false;
            };
        };


        //usernameEl.set('value',this.prefix(username,'contact'));

        $('loginForm').submit();
        $('loginForm').getElement('button').addClass('logining');
    },

    refresh : function(){
        $('vimg').src = '/share/vimg?'+ new Date().getTime();
    },

    prefixReg : {
            '^jsh.*$':'@sp.sasac.gov.cn'
    },

    prefix : function(str,type){
        if(type == 'contact'){
            for(var key in this.prefixReg){
                if(new RegExp(key).test(str)){
                    str = str + this.prefixReg[key];
                    return str;
                };
                return str;
            }
        }else if(type == 'substring'){
            for(var key in this.prefixReg){
                var index = str.indexOf(this.prefixReg[key]);
                if(index != -1){
                    str = str.substring(0,index);
                    return str;
                };
                return str;
            }
        };

        return str;
    },

    init :function(){
        var _self = this;

        $('loginForm').addEvent('submit',function(event){
            event.stop();
            _self.validate();
        });

        var email = Cookie.read('remenber_email');
        console.log(email);
        try{
            if(email){
                if($('username').get('value').trim().length == 0) $('username').set('value',email);
                setTimeout(function(){
                    $('password').focus();
                },100)

            }else{
                $('username').focus();
            };

            //$('username').set('value',this.prefix($('username').get('value'),'substring'));
        }catch(e){

        }
    }
};

tagIndex = {
    'init':function(){
        var _self = this;
        this.tag = $('tag').getChildren();
        this.ul = $('newItemList').getChildren();
        this.tag.each(function(item,index){
            item.addEvent('mouseenter',function(event){
                _self.tag.each(function(innertag){
                    innertag.removeClass('current');
                });
                item.addClass('current');
                _self.ul.each(function(innerUL){
                    innerUL.setStyle('display','none');
                });
                _self.ul[index].setStyle('display','');
            });

        });
    }
}

picList = {
    'toIndex':function(index){
        if(this.index == index) return;
        var _self = this;
        $clear(this.setTimeout);
        this.index = index;
        this.picList.each(function(item){
            item.setStyle('visibility','hidden');
        });
        this.picList[index].setStyle('visibility','visible');
        this.picButton.each(function(item){
            item.getElement('.mask').setStyle('display','');
        });

        this.picButton[index].getElement('.mask').setStyle('display','none');
        this.setTimeout = setTimeout(function(){
            _self.toIndex(_self.next());
        },3000);
    },
    'next':function(){
        return this.index + 1 > this.picList.length - 1 ? 0 : this.index + 1;
    },
    'init':function(){
        var _self = this;
        this.picList = $('focusPic').getChildren();
        this.picButton = $('focusButton').getChildren();
        this.picButton.each(function(item,index){
            item.addEvent('mouseenter',function(event){
                item.getElement('.mask').setStyle('display','none');
                _self.toIndex(index);
            });
        });
        _self.toIndex(0);
    }
}

    /*
    功能:URL操作
    */
    URL = {

        _HashObj:{},
        _QueryObj:{},
        /*
            功能：设定hash值
            参数：a1:Hash键 {string}, a2:Hash值 {string}, a3 Hash原始保护{true/false} true 如果key存在不进行值替换 false如果key存在进行值替换
        */
        setHash:function(a1,a2,a3){
            this.getHashObj();
            //获得当前页面的URLHash
            if(a1 instanceof Object){
                this.injectObj(a1,'',this._HashObj,a3);
            }else{
                this.injectObj(a1,a2,this._HashObj,a3);
            };
            location.hash = this.format(this._HashObj);
        },

        //获得Hash值
        getHash:function(key){
            this.getHashObj();
            if(key == undefined){
                return this._HashObj;
            }else{
                for(var hashkey in this._HashObj){
                    if(key == hashkey.toString()) return this._HashObj[hashkey];
                };
                return null;
            };
        },

        //已对象形式获得当前Hash
        getHashObj:function(){
            var HashObj = this._HashObj = {};
            var Hash = location.hash;

            if(Hash.length > 0){
                Hash = Hash.slice(1);
                Hash = Hash.split('&');
                for(var i = 0; i < Hash.length; i++){
                    var item = Hash[i].split('=');
                    HashObj[item[0]] = item[1];
                };
            };
            this._HashObj = HashObj;
        },

        setQuery:function(a1,a2,a3){
            this.getQueryObj();
            if(a1 instanceof Object){
                this.injectObj(a1,'',this._QueryObj,a3);
            }else{
                this.injectObj(key,value,this._QueryObj,protect);
            };
            location.search = this.format(this._QueryObj);
        },

        getQuery:function(key){
            this.getQueryObj();
            if(key == undefined){
                return this._QueryObj;
            }else{
                for(var querykey in this._QueryObj){
                    if(key == querykey.toString()) return this._QueryObj[querykey];
                };
                return null;
            };
        },

        getQueryObj:function(){
            var QueryObj = this._QueryObj = {};
            var Query = location.search;

            if(Query.length > 0){
                Query = Query.slice(1);
                Query = Query.split('&');
                for(var i = 0; i < Query.length; i++){
                    var item = Query[i].split('=');
                    QueryObj[item[0]] = item[1];
                };
            };
            this._QueryObj = QueryObj;
        },

        //插入当前值到对象
        //a1: 键 后者 一个对象,a2：值,obj: 插入对象,protect: 是否保护
        injectObj:function(a1, a2 ,obj, protect){
            var valueProtect = protect ? protect : false;
            if(a1 instanceof Object){
                for(var key in a1){
                    var inject = true;
                    for(var objkey in obj){
                        if(key.toString() == objkey.toString() && valueProtect == true){
                            inject = false;
                            return;
                        }
                    };
                    if(inject == true){
                        obj[key] = a1[key];
                    };
                };
            }else{
                if(valueProtect == true){
                    if(obj.hasOwnProperty(a1) != true) obj[a1] = a2;
                }else{
                    obj[a1] = a2;
                };
            };
        },

        format: function(obj){
            var returnArray = [];
            for(var key in obj){
                returnArray.push(key + '=' + obj[key]);
            };
            return returnArray.join('&');
        }
    };


/*
---
description: Date picker that works in an iframe and allows for keyboard navigation.

license: MIT-style

authors:
- Micah Nolte

requires:
- core:1.2.4
- core:1.2.4/Array
- core:1.2.4/String
- /MooTools.More
- /Date
- /IFrameShim

provides: [SlimPicker]

...
*/

var SlimPicker = new Class({

    Implements: [Options, Events],

    options: {
        containerClass: 'sp_container',   // This will always start at the top left of the input's location.
        calendarClass: 'sp_cal',          // Use this to alter the placement of the calendar in the CSS.
        hoverClass: 'sp_hover',           // If using the keyboard, this gets moved around the calendar by arrow keys.
        selectedClass: 'sp_selected',     // The date picked up from what was in the input field.
        todayClass: 'sp_today',           // Always just on today. The sp_selected usually overrides this.
        emptyClass: 'sp_empty',           // Placed on the <td> of a date with no day in it.
        dayClass: 'sp_day',               // Placed on the <td> with a day in it.
        monthClass: 'sp_month',           // On the dropdown for month.
        yearClass: 'sp_year',             // On the dropdown for year.

        fadeDuration: 200,                // How fast the calendar fades in and out.
        hideDelay: 500,                   // How long to wait to close the calendar after the mouse leaves.
        extendedDelay: 5000,              // After a dropdown is open, how long to wait before we give up and hide the calendar.
        showMonth: true,                  // Add the dropdown select for month.
        showYear: true,                   // Add the dropdown select for year.
        autoHide: true,                   // Without this, it won't set a timer to hide the calendar whenever you move away.
        forceDocBoundary: true,           // If the calendar would be shown outside the document, then flip the direction it shows up.
        destroyWhenDone: true,           // After selecting a date, true will remove the calendar completely, and false just hides it.

        // Settings for the calendar itself
        dayChars: 1,
        monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
        dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31], // Leap year is added later
        format: 'yyyy-mm-dd',                                          // How the output looks after selection
        yearStart: (new Date().getFullYear() - 2),                     // Default starting year for dropdown options is 5 years ago
        yearRange: 2,                                                 // Show a 10 year span
        yearOrder: 'asc',                                              // Counting up in years
        startDay: 7                       // 1 = week starts on Monday, 7 = week starts on Sunday
    },

    initialize: function(el, options) {
        // Saving the input field
        this.input = $(el);
        if(!this.input) return;
        // There are two ways to set the options on the fly.

        // They can be passed in when this class is started up.
        this.setOptions(options);



        // Any options in the alt attribute will overwrite ones passed into the initializer
        if (this.input.get('alt')) this.setOptions(JSON.decode(this.input.get('alt')));

        // Saving the document, in case it's in a frame window.
        this.doc = this.input.ownerDocument;
        this.docSize = this.doc.getScrollSize();

        // This sets several instance variables
        this.setCurrentDate();

        // Adding onClick and onFocus events
        this.input.addEvent('click', this.show.bind(this)).addEvent('focus', this.show.bind(this));

        // Watch the keyboard clicks. Since we can't remove this later, just add it once.
        this.doc.addEvent((Browser.Engine.trident || Browser.Engine.webkit) ? 'keydown' : 'keypress', this.checkKeys.bindWithEvent(this));

        // Setting the state of the calendar as off.
        this.open = false;
        this.dropDownShowing = false;
    },

    setCurrentDate: function() {
        var inputValue = this.input.get('value');
        this.now = new Date();
        if (inputValue != '') {
            this.current = new Date.parse(inputValue);
        } else {
            this.current = this.now;
        }
        // The date to show on the calendar
        this.currentYear = this.calendarYear = this.current.getFullYear();
        this.currentMonth = this.calendarMonth = this.current.getMonth();
        this.currentDay = this.current.getDate();

        // Keeping track of today to show on the calendar
        this.nowYear = this.now.getFullYear();
        this.nowMonth = this.now.getMonth();
        this.nowDay = this.now.getDate();
    },

    show: function() {
        if (this.open) return true;
        this.open = true;
        if (!this.container) this.create();
        this.draw();
        if (this.shim) this.shim.show();
        this.container.set('tween', {duration: this.options.fadeDuration}).fade(1);
    },

    close: function() {
        this.open = false;
        this.dropDownShowing = false;
        this.removeTimer();
        if (!this.container) return false;
        this.container.set('tween', {onComplete: this.destroyCal.bind(this)}).fade(0);
        if (this.shim) this.shim.hide();
    },

    destroyCal: function() {
        if (!this.options.destroyWhenDone) return true;
        this.container.destroy();
        this.container = false;

    },

    checkKeys: function(e) {
        if (!this.open) {
            return true;
        }
        var availableKeys = ['tab', 'esc', 'enter', 'up', 'down', 'left', 'right']
        if (availableKeys.contains(e.key)) {
            switch (e.key) {
                // If there's a selected day, use that one.
                case 'enter':
                    e.stop();
                    this.tryHoverSelect();
                    break;

                case 'esc':
                    e.stop();
                    this.close();
                    break;

                // Change the focus?
                case 'tab':
                    // On a shift-tab, reverse direction
                    this.close();
//                    this.moveFocus(e.shift);
                    break;

                // The rest are the directions
                default:
                    e.stop();
                    this.moveSelection(e.key);
                    break;
            }
        }
    },

    tryHoverSelect: function() {
        var link = this.hoveredDay.getElement('a');
        if (link) {
            this.useSelection(link);
        }
    },

    useSelection: function(el) {
        if (!el) return false;
        var dateArray = el.get('href').split('#')[1].split('|');
        this.input.value = this.formatValue(dateArray[0], dateArray[1], dateArray[2]);
        this.close();
    },

    // Keyboard arrow keys. Wraps around horizontally, but will access the dropdowns and wrap if you move up.
    moveSelection: function(direction) {
        switch (direction) {
            case 'up':
                this.hoverRow = this.hoverRow - 1;
                if (this.hoverRow < 1) {
                    this.hoverRow = this.calendarRows;
                }
                break;
            case 'down':
                this.hoverRow = this.hoverRow + 1;
                if (this.hoverRow > this.calendarRows) {
                    this.hoverRow = 1;
                }
                break;
            case 'left':
                // Row 0 is the dropdown row
                this.hoverCol = this.hoverCol - 1;
                if (this.hoverCol < 0) {
                    this.hoverCol = 6;
                }
                break;
            case 'right':
                this.hoverCol = this.hoverCol + 1;
                if (this.hoverCol > 6) {
                    this.hoverCol = 0;
                }
                break;
        }
        this.markHoveredDay();
    },

    // Just applies whatever is saved as the hovered day to the calendar.
    // If there aren't that many rows, it pushes it up until there is one.
    markHoveredDay: function() {
        if (this.hoverRow > this.calendarRows) this.hoverRow = this.calendarRows;
        // Row 0 is the dropdown selector one.
        if (this.hoverRow == 0) {
            // Since there's only two, either left or right
            this.calendar.getElements('.'+this.options.hoverClass).removeClass(this.options.hoverClass);

        } else {
            var row = this.calendar.getElements('tbody tr')[this.hoverRow];
            this.hoveredDay = row.getElements('td')[this.hoverCol];
            this.calendar.getElements('.'+this.options.hoverClass).removeClass(this.options.hoverClass);
            this.hoveredDay.addClass(this.options.hoverClass);
        }
    },

    // TODO: Not currently implemented, due to usability issues.
    // If both are showing, this just switches which one it is.
    // If there's one, it gives it focus.
    moveAndFocusDropdown: function() {
        // Make sure at lease one dropdown is there before doing anything.
        if (!this.options.showMonth && !this.options.showYear) {
            return true;
        }
        // If nothing has been selected, pick the first one.
        if (!this.hoveredDropdown) {
            this.hoveredDropdown = 0;
        // Both dropdowns need to be showing for this to do anything
        } else if (this.options.showMonth && this.options.showYear) {

        }
        this.thead.getElement('select')[this.hoveredDropdown].focus();
    },

    // TODO?
    moveFocus: function(reverse) {
        // Should it start on the month or year dropdown, or the calendar itself?
        // After tabbing away, should it just close the calendar, or determine the next form field?
        // Should there by a highlighting to show what has focus?
    },

    create: function() {
        // Don't need to create it if it already exists.
        if (this.container) {
            return false;
        }
        // Prevent cursor in input field.
        this.input.set('readonly', 'true').set('autocomplete', 'off');
        // The "new Element" doesn't work in frames in IE, so creating it old-school.
        this.container = $(this.doc.createElement('div'));
        // Adding it to the bottom of the document. This allows it to overlay anything we need it to.
        this.container
            .addClass(this.options.containerClass)
            .setStyle('opacity', 0)
            .inject(this.doc.body);

        // Set the transparent container at the top left of the input field.
        this.position();

        // Add a timer for if you move your mouse away from it
        if (this.options.autoHide) {
            this.container.addEvent('mouseenter', this.removeTimer.bind(this)).addEvent('mouseleave', this.addTimer.bind(this));
        }
        this.calendar = $(this.doc.createElement('div'));
        this.calendar.addClass(this.options.calendarClass).inject(this.container);
        this.shim = new IframeShim(this.calendar);
    },

    // String building is such fun.

    draw: function() {
        var str = '<table>';

        // Making dropdowns
        if (this.options.showMonth || this.options.showYear){
            str += this.addMonthYearDropdowns();
        }
        str += '<tbody>';

        var calendarDate = new Date();
        calendarDate.setFullYear(this.calendarYear, this.calendarMonth, 1);
        // Leap year
        this.options.daysInMonth[1] = (calendarDate.isLeapYear() ? 29 : 28);

        // The first day is set as current
        var currentDay = (1-(7+calendarDate.getDay()-this.options.startDay)%7);

        str += '<tr>';
        this.options.dayNames.each( function(name, index) {
            str += '<th>' + this.options.dayNames[(this.options.startDay+index)%7].substr(0, this.options.dayChars) + '</th>';
        }, this);
        str += '</tr>';

        // Keeping track of row for hoveredDay purposes
        var row = 0;
        while (currentDay <= this.options.daysInMonth[this.calendarMonth]){
            row += 1;
            str += '<tr>';
            for (i = 0; i < 7; i++){
                if ((currentDay <= this.options.daysInMonth[this.calendarMonth]) && (currentDay > 0)){
                    str += '<td><a href="#' + this.calendarYear + '|' + (parseInt(this.calendarMonth) + 1) + '|' + currentDay + '" class="' + this.options.dayClass;
                    // Show the currently selected day
                    if ( (currentDay == this.currentDay) && (this.calendarMonth == this.currentMonth) && (this.calendarYear == this.currentYear) ) {
                        str += ' ' + this.options.selectedClass;
                        this.hoverRow = row;
                        this.hoverCol = i;
                    }
                    // Show today
                    if ( (currentDay == this.nowDay) && (this.calendarMonth == this.nowMonth) && (this.calendarYear == this.nowYear) ) {
                        str += ' ' + this.options.todayClass;
                    }
                    str += '">' + currentDay + '</a></td>';
                } else {
                    str += '<td class="' + this.options.emptyClass + '"> </td>';
                }
                currentDay++;
            }
            str += '</tr>';
        }

        str += '</tbody></table>';

        this.calendar.set('html', str);
        this.calendarRows = row;
        this.position();
        this.addCalendarEvents();
    },

    addMonthYearDropdowns: function () {
        var str = '<thead><tr><th colspan="7">';
        if (this.options.showMonth) {
            str += '<select tabindex="'+this.tabIndex+'" class="' + this.options.monthClass + '">';
            this.options.monthNames.each( function(name, index) {
                str += this.addOption(index,name,parseInt(this.calendarMonth));
            }, this);
            str += '</select>';
        }
        if (this.options.showYear) {
            str += '<select tabindex="'+this.tabIndex+'" class="' + this.options.yearClass + '">';
            if (this.options.yearOrder == 'desc'){
                for (var y = this.options.yearStart; y > (this.options.yearStart - this.options.yearRange - 1); y--){
                    str += this.addOption(y,y,parseInt(this.calendarYear));
                }
            } else {
                for (var y = this.options.yearStart; y < (this.options.yearStart + this.options.yearRange + 1); y++){
                    str += this.addOption(y,y,parseInt(this.calendarYear));
                }
            }
            str += '</select>';
        }
        str += '</th></tr></thead>';
        return str;
    },

    addOption: function(value, name, selected) {
        str = '<option value="'+value+'"';
        if (selected && (selected == value)) {
            str += ' selected="selected"';
        }
        str += '>'+name+'</option>';
        return str;
    },

    addCalendarEvents: function() {
        this.tbody = this.calendar.getElement('tbody');
        this.tbody.addEvent('click', this.calendarClick.bindWithEvent(this));
        // Save the dropdown row for accessing with the keyboard later
        this.thead = this.calendar.getElement('thead');
        // Only get and set events for the month/year dropdowns if the options allow it.
        if (this.options.showYear) {
            this.yearSelect = this.calendar.getElement('.'+this.options.yearClass);
            this.yearSelect.addEvent('focus', this.markDropdownShowing.bind(this)).addEvent('change', this.selectChanged.bind(this));
        }
        if (this.options.showMonth) {
            this.monthSelect = this.calendar.getElement('.'+this.options.monthClass);
            this.monthSelect.addEvent('focus', this.markDropdownShowing.bind(this)).addEvent('change', this.selectChanged.bind(this));
        }
    },

    // Get the location/dimensions of the input field and set the container to the same
    position: function() {
        if (!this.input || !this.container) return false;
        var coords = this.input.getCoordinates();
        this.container.setStyles({
            height: coords.height,
            width: coords.width,
            left: coords.left,
            top: coords.top
        });
        if (this.calendar && this.options.forceDocBoundary) this.checkDocBoundary();
        if (this.shim) this.shim.position();
    },

    // If the calendar would show up below the document, make it go up instead
    checkDocBoundary: function() {
        var calSize = this.calendar.getCoordinates();
        if (calSize.right > this.docSize.x) {
            this.calendar.setStyles({left: 'auto', right: 0});
        }
        if (calSize.bottom > this.docSize.y) {
            this.calendar.setStyles({top: 'auto', bottom: 0});
        }
        if (calSize.left < 0) {
            this.calendar.setStyles({left: 0, right: 'auto'});
        }
        if (calSize.top < 0) {
            this.calendar.setStyles({top: 0,bottom: 'auto'});
        }
    },

    // Whenever the dropdown is out, we disable the timer that makes the calendar disappear.
    // We also set a longer timer, in case they don't actually make a selection.
    markDropdownShowing: function() {
        this.dropDownShowing = true;
        this.extendedTimer = this.close.bind(this).delay(this.options.extendedDelay);
    },

    // They made a selection in one of the month/year dropdowns
    selectChanged: function() {
        this.dropDownShowing = false;
        $clear(this.extendedTimer);
        this.calendarMonth = this.monthSelect.get('value');
        this.calendarYear = this.yearSelect.get('value');
        this.draw();
    },

    // A click on the <tbody> happened, so go up until you get a link, or hit the top.
    calendarClick: function(e) {
        var target = $(e.target);
        var target_tag = target.get('tag');
        while((target_tag != 'a') && (target_tag != 'input') && (target_tag != 'html')){
            target = target.getParent();
            if (!target) return;
            target_tag = target.get('tag');
        }
        if (target.hasClass(this.options.dayClass)) {
            e.stop();
            this.useSelection(target);
        }
    },

    addTimer: function() {
        // Checks the "dropDownShowing" in case they have a dropdown open
        if (!this.dropDownShowing) this.timer = this.close.bind(this).delay(this.options.hideDelay);
    },

    removeTimer: function() {
        $clear(this.timer);
    },

    formatValue: function(year, month, day) {
        var dateStr = '';
        if (day < 10) day = '0' + day;
        if (month < 10) month = '0' + month;
        dateStr = this.options.format.replace( /dd/i, day ).replace( /mm/i, month ).replace( /yyyy/i, year );
        this.currentYear = this.calendarYear = year;
        this.currentMonth = this.calendarMonth = '' + (month - 1) + '';
        this.currentDay = day;
        return dateStr;
    }

});
//浮层登录
FloatLogin = {
    'open':function(options){
        this.options = options;
        this.options.oncomplete = this.options.oncomplete || function(){};
        this.options.onclose = this.options.onclose || function(){};
        this.createHTML();
        this.cover.setStyle('visibility','visible');
        ieCover.display(this.cover);
        iframeSet.open('floatLoginiframe','/user/login',{'type':'floatlogin'});
    },

    'display':function(width,height){
        iframeSet.setSize(this.iframe,width,height);
        iframeSet.setSize(this.floatLogin,width,height);
        iframeSet.setCenter(this.floatLogin,width,height);
        this.setCover();

        this.floatLogin.setStyles({
            'z-index':9000,
            'visibility':'visible'
        });
    },

    'close':function(){
        this.hidden();
        this.options.onclose();
    },
    'hidden':function(){
        this.floatLogin.setStyle('visibility','hidden');
        this.cover.setStyle('visibility','hidden');
        ieCover.hidden();
    },

    'createHTML':function(){
        if(this.hasHTML) return;
        var html = '<div class="floatInnerCon">\
                        <iframe id="floatLoginiframe" class="floatIframe" src="" scrolling="no" frameborder="0"></iframe>\
                        <div id="floatLoginShadow" class="floatLoginShadow"></div>\
                    </div>';
        var flaotDiv = new Element('div',{
            'id':'floatLogin',
            'class':'floatCon',
            'styles':{
                'visibility':'hidden'
            }
        });



        var body = document.getElement('body');

        flaotDiv.inject(body,'top');
        flaotDiv.innerHTML = html;
        this.cover = $('cover') || new Element('div',{
            'id':'cover',
            'class':'cover',
            'styles':{
                'visibility':'hidden',
                'top':0,
                'left':0
            }
        });
        this.cover.inject(body,'top');
        this.iframe = $('floatLoginiframe');
        this.floatLoginShadow = $('floatLoginShadow');
        this.floatLogin = $('floatLogin');
        this.hasHTML = true;
    },

    'setCover':function(){
        this.cover.setStyles({
                'width':$(document).getScrollSize().x,
                'height':$(document).getScrollSize().y,
                'opacity': 0.2,
                'z-index':'8900'
            });
    },

    'complete':function(){
        this.hidden();
        this.options.oncomplete();
        this.options.oncomplete = function(){};
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = '/user/banner';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    }
}

Cover = {
    'display':function(){
        this.createCover();
        this.cover.setStyles({
                'width':$(document).getScrollSize().x,
                'height':$(document).getScrollSize().y,
                'opacity': 0.2,
                'z-index':8900
        });
        this.cover.setStyle('visibility','visible');
    },
    'hidden':function(){
        this.cover.setStyle('visibility','hidden');
    },
    'createCover':function(cover){
        if(this.cover) return;
        this.cover = $('cover') || new Element('div',{
            'id':'cover',
            'class':'cover',
            'styles':{
                'visibility':'hidden',
                'top':0,
                'left':0
            }
        });
        this.cover.inject(document.getElement('body'),'top');
    }
}

ieCover = {
    'display':function(cover){
        if(Browser.Engines.trident == 4) return;
        this.createIframe();
        var coverSize = cover.getSize();
        this.iframe.setStyles({
            'width':coverSize.x,
            'height':coverSize.y,
            'z-index':1000,
            'top':cover.getStyle('top'),
            'left':cover.getStyle('left')
        });
        this.iframe.setStyle('visiblity','visible');
    },
    'hidden':function(){
        if(Browser.Engines.trident == 4) return;
        this.createIframe();
        this.iframe.dispose();
        this.iframe = null;
    },
    'createIframe':function(cover){
        if(this.iframe) return;
        this.iframe = new Element('iframe',{
            'styles':{
                'position':'absolute',
                'visiblity':'hidden',
                'opacity':0.2
            }
        });
        this.iframe.inject(document.getElement('body'),'top');
    }
}

//浮层提示
FloatInfo = {
    'open':function(options){
        this.options = options;
        this.createHTML();
        this.options.url = this.options.url;
        this.options.args = this.options.args;
        this.options.onclose = this.options.onclose || function(){};
        this.options.onopen = this.options.onopen || function(){};
        iframeSet.open('floatInfoiframe',this.options.url,this.options.args);
    },
    'display':function(width,height){
        iframeSet.setSize(this.iframe,width,height);
        iframeSet.setSize(this.floatInfo,width,height);
        iframeSet.setCenter(this.floatInfo,width,height);
        this.floatInfoShadow.setStyles({
            'width':width,
            'height':height
        })
        this.setCover();

        this.floatInfo.setStyles({
            'z-index':9900,
            'visibility':'visible'
        });
        this.cover.setStyle('visibility','visible');
        ieCover.display(this.cover);
        this.options.onopen();
    },

    'close':function(){
        this.hidden();
        window.location.href = window.location.href;
    },
    'hidden':function(){
        this.floatInfo.setStyle('visibility','hidden');
        this.cover.setStyle('visibility','hidden');
        ieCover.hidden();
    },
    'createHTML':function(){
        if(this.hasHTML) return;
        var html = '<div class="floatInnerCon">\
                        <iframe id="floatInfoiframe" class="floatIframe" src="" scrolling="no" frameborder="0"></iframe>\
                        <div id="floatInfoShadow" class="floatInfoShadow"></div>\
                    </div>';
        var floatDiv = new Element('div',{
            'id':'floatInfo',
            'class':'floatInfoCon',
            'styles':{
                'visibility':'hidden'
            }
        });

        var body = document.getElement('body');

        floatDiv.inject(body,'top');
        floatDiv.innerHTML = html;
        this.cover = $('cover') || new Element('div',{
            'id':'cover',
            'class':'cover',
            'styles':{
                'visibility':'hidden',
                'top':0,
                'left':0
            }
        });
        this.cover.inject(body,'top');
        this.iframe = $('floatInfoiframe');
        this.floatInfoShadow = $('floatInfoShadow');
        this.floatInfo = $('floatInfo');
        this.hasHTML = true;
    },
    'setCover':function(){
        this.cover.setStyles({
                'width':$(document).getScrollSize().x,
                'height':$(document).getScrollSize().y,
                'opacity': 0.2,
                'z-index':'8900'
            });
    }
}
/*注册验证*/
Reg = {
    'emailLocalFun':function(){
        var _self = this;
        var emailFv = _self.emailF.get('value');
        if(emailFv.length == 0){
            _self.showInfo(_self.emailF,'电子邮箱不能为空');
            _self.allResult.emailLocal = false;
            _self.lock = false;
            return false;
        };
        if(!/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(emailFv)){
            _self.showInfo(_self.emailF,'电子邮箱格式错误');
            _self.allResult.emailLocal = false;
            _self.lock = false;
            return false;
        };
        _self.allResult.emailLocal = true;
        _self.emailAjaxFun();
    },

    'emailAjaxFun':function(){
        var _self = this;
        var emailFv = _self.emailF.get('value');
        var emailFajax = new Request.JSON({
            'method': 'get',
            'url': '/share/interface/checkstudentinfo',
            'data':{
                'email':emailFv
            },
            'onSuccess':function(responseText){
                if(!responseText.success){
                    _self.showInfo(_self.emailF,'该邮箱已经被注册，<a href="/user/repassword/forgetpasword" target="_top>忘记密码？</a>');
                    _self.allResult.emailAjax = false;
                    _self.clickSubmit = false;
                }else{
                    _self.allResult.emailAjax = true;
                    if(!this.clickSubmit) _self.lock = false;
                    _self.checkResult();
                }

            }
        }).send();

    },

    'parentUnitLocalFun':function(){
        var _self = this;
        var parentUnitFv = _self.parentUnitF.get('value').trim();
        if(parentUnitFv.length == 0){
            _self.showInfo(_self.parentUnitF,(this.site_id == 100 ? '选择厅局不能为空' : '集团或主管单位名称不能为空'));
            _self.allResult.parentUnitLocal = false;
            _self.lock = false;
            return false;
        };
        _self.allResult.parentUnitLocal = true;
    },

    'unitLocalFun':function(){
        var _self = this;
        var unitFv = _self.unitF.get('value').trim();
        if(unitFv.length == 0){
            _self.showInfo(_self.unitF,'本单位名称不能为空');
            _self.allResult.unitLocal = false;
            _self.lock = false;
            return false;
        };
        _self.allResult.unitLocal = true;
    },

    'usernameLocalFun':function(){
        var _self = this;
        var usernameFv = _self.usernameF.get('value').trim();
        if(usernameFv.length == 0){
            _self.showInfo(_self.usernameF,'姓名不能为空');
            _self.allResult.usernameLocal = false;
            _self.lock = false;
            return false;
        };
		if(!/[\u4e00-\u9fa5]/.test(usernameFv)){
			 _self.showInfo(_self.usernameF,'姓名应为中文字符');
            _self.allResult.usernameLocal = false;
            _self.lock = false;
            return false;
		}
        _self.allResult.usernameLocal = true;
    },
    'sexLocalFun1':function(){
        var _self = this;
        if(!(this.sexF1.checked) && !(this.sexF2.checked)){
            this.showInfo(this.sexF1,'性别不能为空');
            _self.allResult.sexLocal = false;
            _self.lock = false;
            return false;
        };
        _self.allResult.sexLocal = true;
    },
    'sexLocalFun2':function(){
        var _self = this;
        if(!(this.sexF1.checked) && !(this.sexF2.checked)){
            this.showInfo(this.sexF1,'性别不能为空');
            _self.allResult.sexLocal = false;
            _self.lock = false;
            return false;
        };
        _self.allResult.sexLocal = true;
    },

    'telephoneLocalFun':function(){
        var _self = this;
        var telephoneFv = _self.telephoneF.get('value');
        if(telephoneFv.length == 0){
            _self.showInfo(_self.telephoneF,'手机号码不能为空');
            _self.allResult.telephoneLocal = false;
            _self.lock = false;
            return false;
        };
        if(!/^\d{11}$/.test(telephoneFv)){
            _self.showInfo(_self.telephoneF,'手机号码格式错误，请输入类似格式13512345678');
            _self.allResult.telephoneLocal = false;
            _self.lock = false;
            return false;
        }
        _self.allResult.telephoneLocal = true;
    },

    'passwordLocalFun':function(){
        var _self = this;
        var passwordFv = _self.passwordF.get('value');
        var confirmPasFv = _self.confirmPasF.get('value');
        if(passwordFv.length == 0){
            _self.showInfo(_self.passwordF,'登录密码不能为空');
            _self.allResult.passwordLocal = false;
            _self.lock = false;
            return false;
        };
        if(passwordFv.length < 6 || passwordFv.length > 20){
            _self.showInfo(_self.passwordF,'密码长度必须是6-20位的数字、英文字母和下横线,你输入了 '+passwordFv.length+' 位');
            _self.allResult.passwordLocal = false;
            _self.lock = false;
            return false;
        };
        if(!/^[0-9a-zA-Z_]*$/i.test(passwordFv)){
            _self.showInfo(_self.passwordF,'密码含有非法字符，密码必须是数字、英文字母和下横线的组合');
            _self.allResult.passwordLocal = false;
            _self.lock = false;
            return false;
        };
        if(confirmPasFv != '' && passwordFv != confirmPasFv){
            _self.showInfo(_self.confirmPasF,'两次输入的密码必须一致');
            _self.allResult.passwordLocal = false;
            _self.lock = false;
           return false;
        }
        _self.allResult.passwordLocal = true;
    },
    'confirmPasLocalFun':function(){
        var _self = this;
        var passwordFv = _self.passwordF.get('value');
        var confirmPasFv = _self.confirmPasF.get('value');
        if(confirmPasFv.length == 0){
            _self.showInfo(_self.confirmPasF,'确认密码不能为空');
            _self.allResult.confirmPasLocal = false;
            _self.lock = false;
            return false;
        };
        if(confirmPasFv.length <6 || confirmPasFv.length > 20){
            _self.showInfo(_self.confirmPasF,'密码长度必须是6-20位的数字、英文字母和下横线,你输入了 '+passwordFv.length+' 位');
            _self.allResult.confirmPasLocal = false;
            _self.lock = false;
            return false;
        };
        if(!/^[0-9a-zA-Z_]*$/i.test(confirmPasFv)){
            _self.showInfo(_self.confirmPasF,'确认密码含有非法字符，密码必须是数字、英文字母和下横线的组合');
            _self.allResult.confirmPasLocal = false;
            _self.lock = false;
            return false;
        };
        if(passwordFv != '' && passwordFv != confirmPasFv){
            _self.showInfo(_self.confirmPasF,'两次输入的密码必须一致');
            _self.allResult.confirmPasLocal = false;
            _self.lock = false;
            return false;
        }
        _self.allResult.confirmPasLocal = true;
    },
    'vcodeLocalFun':function(){
        var _self = this;
        var vcodeFv = _self.vcodeF.get('value');
        if(vcodeFv.length == 0){
            _self.showInfo(_self.vcodeF,'验证码不能为空');
            _self.allResult.vcodeLocal = false;
            _self.lock = false;
            return false;
        };
        if(!/^.{4}$/.test(vcodeFv)){
            _self.showInfo(_self.vcodeF,'验证码应为4位');
            _self.allResult.vcodeLocal = false;
            _self.lock = false;
            return false;
        };
        /*var vcodeFajax = new Request.JSON({
            'method': 'get',
            'url': 'http://svn.tcsasac.com/newFront/pages/test.html',
            'data':vcodeFv,
            'onSuccess':function(responseText){
                if(!responseText.success){
                    _self.showInfo(_self.vcodeF,'验证码错误，请重新输入');
                    //_self.vcodeF.focus();
                    return false;
                }
            }

        }).send();*/
        _self.allResult.vcodeLocal = true;

    },
    'personRepeatAjaxFun':function(){
        var _self = this;
        var sexFv;
        if(_self.parentUnitF.get('value').trim() != '' && _self.usernameF.get('value').trim() != '' && _self.telephoneF.get('value').trim() != ''){
            if(_self.sexF1.checked){
                sexFv = _self.sexF1.get('value').trim();
            }
            if(_self.sexF2.checked){
                sexFv = _self.sexF2.get('value').trim();
            }
			
			var data = {
                    'parentUnitID':$('parentUnitFid').get('value').trim(),
                    'username':_self.usernameF.get('value').trim(),
                    'sex':sexFv,
                    'telephone':_self.telephoneF.get('value').trim()				
			};
			if(_self.unitF) data['unit']=_self.unitF.get('value').trim();
			
            var personRepeatajax = new Request.JSON({
                'method': 'get',
                'url': '/share/interface/checkstudentinfo',
                'data':data,
                'onSuccess':function(responseText){
                    if(!responseText.success){
                        _self.showInfo(_self.usernameF,'该用户信息已被注册，<a href="/user/getemail" target="_top">忘记账号？</a>');
                        _self.allResult.parentUnitAjax = false;
                        _self.allResult.usernameAjax = false;
                        _self.allResult.sexAjax = false;
                        _self.allResult.telephoneAjax = false;
                        _self.clickSubmit = false;
                        _self.lock = false;
                    }else{
                        _self.usernameF.removeClass('error');
                        _self.usernameF.getParent().getNext().removeClass('error').set('html','');
                        _self.allResult.parentUnitAjax = true;
                        _self.allResult.usernameAjax = true;
                        _self.allResult.sexAjax = true;
                        _self.allResult.telephoneAjax = true;
                        if(!this.clickSubmit) _self.lock = false;
                        _self.checkResult();
                    }
                }

            }).send();
        }

    },
    'checkResult':function(){
        if(!this.clickSubmit) return;
        console.log(this.allResult);
        var _self = this;
        var resultArr = [];
        for(var key in _self.allResult){
            if(!_self.allResult[key]){
                return;
            }else{
                resultArr.push(_self.allResult[key])
            }
        }
        if(resultArr.indexOf(false) == -1){
            this.lock = true;
            $('regSubmit').innerHTML = '提交中';
            $('regForm').submit();
        }
    },
    'validate':function(){
        console.log('1')
        this.emailLocalFun();
        if(!this.allResult.emailLocal){ this.lock = false; return;}
        console.log('2')
        this.parentUnitLocalFun();
        if(!this.allResult.parentUnitLocal){ this.lock = false; return;}
        console.log('3')
		if(this.unitF){
			this.unitLocalFun();
		}else{
			 this.allResult.unitLocal = true;
		};
        if(!this.allResult.unitLocal){ this.lock = false; return;}
        console.log('4')
        this.usernameLocalFun();
        if(!this.allResult.usernameLocal){ this.lock = false; return;}
        console.log('5')
        this.sexLocalFun1();
        if(!this.allResult.sexLocal){ this.lock = false; return;}
        console.log('6')
        this.sexLocalFun2();
        if(!this.allResult.sexLocal){ this.lock = false; return;}
        console.log('7')
        this.telephoneLocalFun();
        if(!this.allResult.telephoneLocal){ this.lock = false; return;}
        console.log('8')
        this.passwordLocalFun();
        if(!this.allResult.passwordLocal){ this.lock = false; return;}
        console.log('9')
        this.confirmPasLocalFun();
        if(!this.allResult.confirmPasLocal){ this.lock = false;  return;}
        console.log('10')
        this.vcodeLocalFun();
        if(!this.allResult.vcodeLocal){ this.lock = false; return;}
        this.personRepeatAjaxFun();
        this.checkResult();
    },


    'showInfo':function(element,info){
        element.addClass('error')
        element.getParent().getNext().addClass('error').set('html',info);
    },

    'bindEvent':function(){
        var _self = this;
        _self.inputArr = $('regForm').getElements('input');
        _self.tipsArr = $('regForm').getElements('.tip');
        _self.infoArr = {
            'emailF':'请输入真实的邮箱，登录时使用',
            'unitF':'请输入单位的全称',
            'passwordF':'密码必须是6-20位的数字、英文字母和下横线'
        };
        _self.emailF.getParent().getNext().removeClass('error').set('html',_self.infoArr['emailF']);

        if(_self.unitF)_self.unitF.getParent().getNext().removeClass('error').set('html',_self.infoArr['unitF']);

        _self.passwordF.getParent().getNext().removeClass('error').set('html',_self.infoArr['passwordF']);
        _self.inputArr.each(function(item,index){
            item.addEvent('focus',function(){
                    this.removeClass('error');
                    if(_self.infoArr[this.id]){
                        this.getParent().getNext().removeClass('error').set('html',_self.infoArr[this.id]);
                    }else{
                        this.getParent().getNext().removeClass('error').set('html','');
                    }

                })
        });
        _self.parentUnitF.addEvent('focus',function(){
            //alert(_self.site_id);
            parentUnitOption.open(_self.site_id);
        });

        _self.emailF.addEvent('blur',function(){
            _self.emailLocalFun();
        });
        //_self.parentUnitF.addEvent('blur',function(){
            //_self.parentUnitFun();
        //});

		if( _self.unitF){		
			_self.unitF.addEvent('blur',function(){
				_self.unitLocalFun();
			});
		};

        _self.usernameF.addEvent('blur',function(){
            _self.usernameLocalFun();
            //_self.personRepeatAjaxFun();
        });
        _self.telephoneF.addEvent('blur',function(){
            _self.telephoneLocalFun();
            //_self.personRepeatAjaxFun();
        });
        _self.passwordF.addEvent('blur',function(){
            _self.passwordLocalFun();
        });
        _self.confirmPasF.addEvent('blur',function(){
            _self.confirmPasLocalFun();
        });

        _self.sexF1.addEvent('blur',function(){
            _self.sexLocalFun1();
            //_self.personRepeatAjaxFun();
        });
        _self.sexF2.addEvent('blur',function(){
            _self.sexLocalFun2();
            //_self.personRepeatAjaxFun();
        });
        _self.vcodeF.addEvent('blur',function(){
            _self.vcodeLocalFun();
        });

        $('vimgF').addEvent('click',function(){
            _self.refresh();
        });
    },

    'refresh' : function(){
        $('vimgF').src = '/share/vimg?'+ new Date().getTime();

    },
    'getEls':function(){
        this.emailF = $('emailF');
        this.parentUnitF = $('parentUnitF');
        this.unitF = $('unitF');
        this.usernameF = $('usernameF');
        this.sexF1 = $('sexF1');
        this.sexF2 = $('sexF2');
        this.telephoneF = $('telephoneF');
        this.passwordF = $('passwordF');
        this.confirmPasF = $('confirmPasF');
        this.vcodeF = $('vcodeF');
    },

    //site_id add by mark
    //主要是为了满足各个分站的注册个性化需求
    'init':function(site_id){
        //alert(site_id);
        var _self = this;
        this.allResult = {
            'emailLocal':false,
            'emailAjax':false,
            'parentUnitLocal':false,
            'parentUnitAjax':false,
            'unitLocal':false,
            'usernameLocal':false,
            'usernameAjax':false,
            'sexLocal':false,
            'sexAjax':false,
            'telephoneLocal':false,
            'telephoneAjax':false,
            'passwordLocal':false,
            'confirmPasLocal':false,
            'vcodeLocal':false
        };
        this.site_id = site_id;
        this.lock = false;

        this.getEls();
        this.bindEvent();
        $('regForm').addEvent('submit',function(event){
            event.stop();
            if(!_self.lock){
                _self.lock = true;
                //只有手工提交时进行submit
                _self.clickSubmit = true;
                for(var key in _self.allResult){
                    _self.allResult[key] == false;
                };
                _self.validate();
            };
        })
    }
};


//上级集团选择器
parentUnitOption = {
    feedBack:function(data){
        this.addItem(data);
        this.close();
    },

    addItem : function(data){
        $('parentUnitF').set('value',data.name);
        $('parentUnitFid').set('value',data.id);
    },
    display:function(width,height){
        iframeSet.setSize(this.iframe,width,height);
        iframeSet.setSize(this.floatUnit,width,height);
        iframeSet.setCenter(this.floatUnit,width,height);
        this.floatUnitShadow.setStyles({
            'width':width,
            'height':height
        })
        this.setCover();

        this.floatUnit.setStyles({
            'z-index':10000,
            'visibility':'visible',
            'position':'absolute'
        });

        this.cover.setStyle('visibility','visible');
    },
    'createHTML':function(){

        if(this.hasHTML) return;

        var html = '<div class="floatInnerCon">\
                        <iframe id="floatUnitSelecteriframe" class="floatIframe" src="" scrolling="no" frameborder="0"></iframe>\
                        <div id="floatUnitShadow" class="floatUnitShadow"></div>\
                        </div>';
        var floatDiv = new Element('div',{
            'id':'floatUnit',
            'class':'floatRegCon',
            'styles':{
                'visibility':'hidden'
            }
        });

        var body = document.getElement('body');

        floatDiv.inject(body,'top');
        floatDiv.innerHTML = html;
        this.cover = new Element('div',{
            'id':'cover1',
            'class':'cover',
            'styles':{
                'visibility':'hidden'
            }
        });
        this.cover.inject(body,'top');
        this.iframe = $('floatUnitSelecteriframe');
        this.floatUnit = $('floatUnit');
        this.floatUnitShadow = $('floatUnitShadow');
        this.hasHTML = true;
    },
    open:function(site_id){
        this.createHTML();
		var data = {'tpl':'fcuname'};
		if(site_id) data.site_id = site_id;
        iframeSet.open('floatUnitSelecteriframe','/share/interface/culist',data);

        //,{'type':'simple','id':$('parentUnitFid').get('value')});
    },
    'setCover':function(){
        this.cover.setStyles({
                'width':$(document).getScrollSize().x,
                'height':$(document).getScrollSize().y,
                'opacity': 0.2,
                'z-index':'8900'
            });
    },
    'close':function(){
        this.floatUnit.setStyle('visibility','hidden');
        this.cover.setStyle('visibility','hidden');
    },
    //选择器辅助搜索功能
    'ajaxSearch': function(){
        var _self = this;

        this.ajaxSearchDom = {
            'groupSearchForm':$('groupSearchForm'),
            'serachString':$('serachString'),
            'defaultText':$('serachString').get('value'),
            'stringName':$('serachString').get('value'),
            'serachType':$('serachType'),
            'typeMenu':$('typeMenu').getElements('a'),
            'serachResultList':$('serachResultList')

        };

        this.ajaxSearchDom.groupSearchForm.addEvent('submit',function(event){
            event.stop();
        });

        this.ajaxSearchDom.serachString.setStyle('color','#848484');

        this.ajaxSearchDom.serachString.addEvents({
            'focus':function(){
                    if(_self.ajaxSearchDom.defaultText == _self.ajaxSearchDom.serachString.get('value')){
                        _self.ajaxSearchDom.serachString.set('value','');
                        _self.ajaxSearchDom.serachString.setStyle('color','#333333');
                    }
            },
            'blur':function(){
                if(_self.ajaxSearchDom.serachString.get('value').trim().length == 0){
                    _self.ajaxSearchDom.serachString.set('value',_self.ajaxSearchDom.defaultText);
                    _self.ajaxSearchDom.serachString.setStyle('color','#848484');
                };
            },
            'keydown':function(){
                if(_self.searchTimeout) $clear(_self.searchTimeout);
            },
            'keyup':function(){
                if(_self.searchTimeout) $clear(_self.searchTimeout);
                if(_self.ajaxSearchDom.serachString.get('value') != _self.ajaxSearchDom.defaultText){
                    _self.searchTimeout = setTimeout(function(){
                        _self.ajaxPost();
                    },300);
                };
            }
        });
    },
    'ajaxPost' : function(){
        var _self = this;
        var QueryData = {};
        QueryData[this.ajaxSearchDom.serachString.get('name')] = this.ajaxSearchDom.serachString.get('value') != this.ajaxSearchDom.defaultText ? this.ajaxSearchDom.serachString.get('value') : '';
        QueryData[this.ajaxSearchDom.serachType.get('name')] = this.ajaxSearchDom.serachType.get('value');
        QueryData.random = new Date().getTime() + $random(1,10);
        this.ajaxRequest = new Request({
            url : '/share/interface/cusearch',
            method : 'get',
            data : QueryData,
            onSuccess : function(responseText){
                _self.ajaxSearchDom.serachResultList.innerHTML = responseText;
            }
        }).send();
    },
    'setType':function(dom,data){
        this.ajaxSearchDom.typeMenu.each(function(item){
            item.getParent().removeClass('current');
        });
        console.log(this)
        $(dom).getParent().addClass('current');
        this.ajaxSearchDom.serachType.set('value',data);
        this.ajaxPost();
    }
};

//根页面上级单位选择器反馈
parentUnitFeedBack = function(data){
    $('floatUnit').setStyle('visibility','hidden');
    $('cover1').setStyle('visibility','hidden');
    parentUnitOption.feedBack(data);
};

//浮层注册
FloatReg = {
    'open':function(options){
        this.options = options;
        this.options.oncomplete = this.options.oncomplete;
        this.options.onclose = this.options.onclose || function(){};
        this.createHTML();
        this.cover.setStyle('visibility','visible');
        ieCover.display(this.cover);
        iframeSet.open('floatRegiframe','/user/reg',{'tpl':'freg'});
    },
    'display':function(width,height){
        iframeSet.setSize(this.iframe,width,height);
        iframeSet.setSize(this.floatReg,width,height);
        iframeSet.setCenter(this.floatReg,width,height);
        this.floatRegShadow.setStyles({
            'width':width,
            'height':height
        })
        this.setCover();

        this.floatReg.setStyles({
            'z-index':9000,
            'visibility':'visible'
        });
    },

    'close':function(){
        this.floatReg.setStyle('visibility','hidden');
        this.cover.setStyle('visibility','hidden');
        ieCover.hidden();
        this.options.onclose();
    },
    'createHTML':function(){
        if(this.hasHTML) return;
        var html = '<div class="floatInnerCon">\
                        <iframe id="floatRegiframe" class="floatIframe" src="" scrolling="no" frameborder="0"></iframe>\
                        <div id="floatRegShadow" class="floatRegShadow"></div>\
                    </div>';
        var floatDiv = new Element('div',{
            'id':'floatReg',
            'class':'floatRegCon',
            'styles':{
                'visibility':'hidden'
            }
        });

        var body = document.getElement('body');

        floatDiv.inject(body,'top');
        floatDiv.innerHTML = html;

        this.cover = $('cover') || new Element('div',{
            'id':'cover',
            'class':'cover',
            'styles':{
                'visibility':'hidden',
                'top':0,
                'left':0
            }
        });
        this.cover.inject(body,'top');
        this.iframe = $('floatRegiframe');
        this.floatRegShadow = $('floatRegShadow');
        this.floatReg = $('floatReg');
        this.hasHTML = true;
    },
    'setCover':function(){
        this.cover.setStyles({
                'width':$(document).getScrollSize().x,
                'height':$(document).getScrollSize().y,
                'opacity': 0.2,
                'z-index':'8900'
            });
    },
    'complete' : function(){
        var _self = this;
        if(!this.options.oncomplete) {
            this.options.oncomplete =  function(){
                setTimeout(function(){
                    _self.close();
                },5000);

            }
        }
        this.options.oncomplete();
    }
}
//打开登录还是注册浮层
isLoginFloat = {
    'init':function(){
        FloatInfo.open({
            'url':'/interface/statics/show',
            'onclose':function(){
                window.location.href = window.location.href;
            },
            'args':{
                'tpl':'fnotice'
            }
        });
    }
}
//打开重复报名浮层
isRepeatFloat = {
    'init':function(){
        FloatInfo.open({
            'url':'/interface/statics/show',//浮层重复报名的地址
            'onclose':function(){
                window.location.href = window.location.href;
            },
            'args':{
                'tpl':'freapply'
            }
        });
    }
}

//打开报名表单页的登录浮层
signForm = {
    'openFloatLogin':function(){
        var _self = this;
        top.FloatLogin.open({
            'onclose':function(){
                top.window.location.href = top.window.location.href;
            },
            'oncomplete':function(){
                top.FloatInfo.open({
                    'url':'/user/login/floginsuccess',
                    'onopen':function(){
                        setTimeout(function(){
                            top.FloatInfo.close();
                        },5000);
                    }
                })
            }
        });
    },
    'openFloatReg':function(){
        var _self = this;
        top.FloatReg.open({
            'onclose':function(){
                top.window.location.href = top.window.location.href;
            }
        })
    }
}
//iframe基础操作
iframeSet = {
    setSize : function(target, width, height){
        var t = $(target);

        if(typeof width == 'string'){
            t.set('width',width);
        }else{
             t.set('width',width + 'px');
        }
        t.set('height',height + 'px');
    },
    setPosition : function(target,x,y){
        $(target).setStyles({
            'top':x + 'px',
            'left':y + 'px'
        });
    },
    setCenter : function(target, width, height){
        var windowSize = window.getSize();
        var x,y
        if(target.getStyle('position') == 'position'){
            var bodyScroll = document.getElement('body').getScroll();
            x = Math.round((windowSize.y - height) / 2 + bodyScroll.y);
            y = Math.round((windowSize.x - width) / 2 + bodyScroll.x);
        }else{
            x = Math.round((windowSize.y - height) / 2);
            y = Math.round((windowSize.x - width) / 2);
        }
        this.setPosition(target,x,y);
    },

    display : function(target, width, height){
        var t = $(target);
        this.setSize(t,width, height);
        t.setStyle('visibility','visible');
        top.iframeFloatControl.display(width,height);
    },

    open : function(target,src,data){
        var datatoString = function(data){
            var urlQuery = [];
            for(var key in data){
                urlQuery.push(key + '=' + data[key]);
            };
            return urlQuery.join('&');
        }

        data = data || {};
        data['target'] = target;

        if(data) src = src + '?' + datatoString(data);
        $(target).set('src',src);
    },

    close :function(target){
        var t = $(target);
        t.setStyle('visibility','hidden');
        t.set('src','');
    },

    resetSize : function(iframename){
        var iframe = iframename || 'contentIframe'
        var size = $('contentCon').getSize();
        top.iframeSet.setSize(iframe,'100%',size.y < 600 ? 600 : size.y);
    }
};

//根页面与浮层iframe交互用
iframeFloatControl = {
    'display' : function(width,height){
        //if(!this.shim) this.shim = new IframeShim($('cover'));
        //if(this.shim) this.shim.show();
        //if(this.shim) this.shim.position();
        $('shadow').setStyles({
            'width': width + 'px',
            'height': height + 'px'
        });

        $('iframeFloat').setStyles({
            'width': width + 'px',
            'height': height + 'px'
        });
        iframeSet.setCenter('iframeFloat',width,height);
        $('iframeFloat').setStyle('visibility','visible');
        $('cover').setStyles({
                'width':$(document).getScrollSize().x,
                'height':$(document).getScrollSize().y,
                'opacity': 0.5,
                'visibility':'visible',
                'z-index':'9000'
            });

        if(Browser.Engine.trident4){
            $('contentIframe').contentWindow.document.getElements('select').each(function(item){
                if(item.getStyle('visibility') != 'hidden') item.setStyle('visibility','hidden');
            });
        }


    },
    'close' : function(){
        $('iframeFloat').setStyle('visibility','hidden');
        $('cover').setStyle('visibility','hidden');
        iframeSet.close('inneriframeFloat');
        //if(this.shim) this.shim.hide();

        if(Browser.Engine.trident4){
            $('contentIframe').contentWindow.document.getElements('select').each(function(item){
                if(item.getStyle('visibility') == 'hidden' && item.get('trident') == '1') item.setStyle('visibility','visible');
            });
        }
    }
};

//简易ajax
simpleAjax = function(){
    var url,data,method, succeed, failure, cancal;

    url = arguments.length == 1 ? arguments[0] : '';
    data = arguments.length == 2 ? arguments[1] : {};
    if(arguments.length == 3){
        if(arguments[2] == 'post'){
            method = 'post';
        }else if(arguments[2] == 'get'){
            method = 'get';
        }else{
            method = 'get';
        }
    };

    if(arguments.length == 4){
        if(arguments[3] == 'function'){
            succeed = arguments[3];
        }else{
            succeed = function(){};
        }
    };

    if(arguments.length == 5){
        if(arguments[4] == 'function'){
            failure = arguments[4];
        }else{
            failure = function(){};
        }
    };

    if(arguments.length == 6){
        if(arguments[5] == 'function'){
            cancal = arguments[4];
        }else{
            cancal = function(){};
        }
    };

    var ajax = new Request.JSON({
        'url':url,
        'data':data,
        'method':method,
        'onSuccess':succeed,
        'onFailure':failure,
        'onCancel':cancal
    });

    return ajax;
}

//浮层消息
messageBox = {
        /*
            options = {
                'title':{string},
                'content':{string},
                'enter':{function},
                'cancel':{function},
                'timeout':{int} ms,
                'cover':true,
                'focus':{string} enter,cancel
            }
        */
        'setInfo':function(options){
            this.hasMain();
            this.type = 'info';
            this.cover = false;
            this.enterButton = true;
            this.cancelButton = false;
            this.title = options.title || '提示信息';
            this.content = options.content || '';
            this.timeout = options.timeout || 3000;
            this.enterfunction = options.enter || function(){};
            this.cancelfunction = options.cancel || function(){};
            this.focus = options.focus || false;
            return this;
        },
        'setConfirm':function(options){
            this.hasMain();
            this.type = 'confrim';
            this.cover = true;
            this.enterButton = true;
            this.cancelButton = true;
            this.title = options.title || '确认信息';
            this.content = options.content || '';
            this.timeout = false;
            this.enterfunction = options.enter || function(){};
            this.cancelfunction = options.cancel || function(){};
            this.focus = options.focus || false;
            return this;
        },
        'setAlert':function(options){
            this.hasMain();
            this.type = 'alert';
            this.cover = false;
            this.enterButton = true;
            this.cancelButton = false;
            this.title = options.title || '提示信息';
            this.content = options.content || '';
            this.timeout = options.timeout || 3000;
            this.enterfunction = options.enter || function(){};
            this.cancelfunction = options.cancel || function(){};
            this.focus = options.focus || false;
            return this;
        },
        'setError':function(options){
            this.hasMain();
            this.type = 'error';
            this.cover = false;
            this.enterButton = true;
            this.cancelButton = false;
            this.title = options.title || '错误信息';
            this.content = options.content || '';
            this.timeout = options.timeout || 3000;
            this.enterfunction = options.enter || function(){};
            this.cancelfunction = options.cancel || function(){};
            this.focus = options.focus || false;
            return this;
        },
        'display':function(){
            this.reset().setType().setContent().setPosition().setButton().hascover().hasTimeout();
            this.mainDom.setStyle('visibility','visible');
            //if(!this.cover)
            ieCover.display(this.coverDom);
            if(this.type == 'error' || this.type == 'info'){
                $('dailog_enter').focus();
            }else if(this.type == 'confrim'){
                if(this.focus == 'enter'){
                    $('dailog_enter').focus();
                }else{
                    $('dailog_canel').focus();
                }
            };

            this.bindEvent(true);
            return this;
        },
        'hidden':function(){
            return this;
        },
        'cancel':function(){
            this.close();
            this.cancelfunction(this);
            return this;
        },
        'enter':function(){
            this.close();
            this.enterfunction(this);
            return this;
        },
        'close':function(){
            this.bindEvent(false);
            ieCover.hidden();
            this.reset();
            return this;
        },
        'setPosition':function(){
            var size = this.dailogconDom.getSize();
            var windowSize = window.getSize();
            var bodyScroll = document.getElement('body').getScroll();
            if(!Browser.Engine.trident4){
                var x = Math.round((windowSize.x - size.x) / 2);
                var y = Math.round((windowSize.y - size.y) / 2);
                //alert('if:' + y);
            }else{
                var x = Math.round((windowSize.x - size.x) / 2 + bodyScroll.x);
                var y = Math.round((windowSize.y - size.y) / 2 + bodyScroll.y);
                //alert('else:' + y);
            }
            this.mainDom.setStyles({
                'left':x + 'px',
                'top':y + 'px'
            });
            if(this.shim) this.shim.position();
            return this;
        },
        'setType':function(){
            if(this.type == 'error'){
                this.mainDom.addClass('error');
            }else{
                this.mainDom.addClass('alert');
            }
            return this;
        },
        'setContent':function(title,content){
            this.titleDom.innerHTML = this.title;
            this.dailog_contentDom.innerHTML = this.content;
            return this;
        },
        'setButton':function(){
            if(this.enterButton) this.dailog_enterDom.setStyle('display','');
            if(this.cancelButton) this.dailog_canelDom.setStyle('display','');
            return this;
        },
        'hasTimeout' : function(){
            var _self = this;
            if(this.timeout != false){

                this.setTimeout = setTimeout(function(){
                    _self.cancel();
                },this.timeout);
            }
            return this;
        },
        'reset':function(){
            clearTimeout(this.setTimeout);
            if(this.coverDom) this.coverDom.setStyle('visibility','hidden');
            this.mainDom.setStyle('visibility','hidden');
            this.mainDom.removeClass('error').removeClass('info').setStyle('visibility','hidden');
            this.dailog_enterDom.setStyle('display','none');
            this.dailog_canelDom.setStyle('display','none');
            this.setContent(' ',' ');
            return this;
        },
        'hascover':function(){
            //if(this.cover){
                if(!this.coverDom){
                    this.coverDom = $('cover') || new Element('div',{
                        'id':'cover',
                        'class':'cover',
                        'styles':{
                            'visibility':'hidden'
                        }
                    });
                    this.coverDom.inject(document.getElement('body'),'top');
                };

                this.coverDom.setStyles({
                    'width':$(document).getScrollSize().x,
                    'height':$(document).getScrollSize().y,
                    'opacity': 0.5,
                    'z-index':1000,
                    'top':0,
                    'left':0,
                    'visibility':'visible'
                });
            //};
            return this;
        },
        'hasMain':function(){
            if($('dailog_box'))return;
            var dailog_box = new Element('div',{
                'id':'dailog_box',
                'class':'dailogFloat',
                'html':'<div class="innerCon">\
                            <div id="dailog_shadow" class="shadow">\
                            </div>\
                            <a id="dailog_close" class="close" href="javascript:void(0);" onclick="messageBox.cancel();">关闭</a>\
                            <div id="dailog_con" class="dailog_con">\
                                <div id="dailog_title" class="dailog_title">\
                                </div>\
                                <div class="dailog_content_con_border">\
                                    <div class="dailog_content_con_border_inner">\
                                        <div class="dailog_content_con_border_inner">\
                                            <div id="dailog_content" class="dailog_content">\
                                            </div>\
                                            <div class="dailog_button">\
                                                <button id="dailog_enter" style="display:none;" onclick="messageBox.enter();">确定</button> <button id="dailog_canel" style="display:none;" onclick="messageBox.cancel();">取消</button>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>',
                'styles':{
                    'visibility':'hidden',
                    'z-index':9000
                }
            });
            dailog_box.inject(document.getElement('body'),'top');
            this.mainDom = $('dailog_box');
            this.shadowDom = $('dailog_shadow');
            this.dailogconDom = $('dailog_con');
            this.titleDom = $('dailog_title');
            this.dailog_contentDom = $('dailog_content');
            this.dailog_enterDom = $('dailog_enter');
            this.dailog_canelDom = $('dailog_canel');
            return this;
        },
        bindEvent:function(bool){
            var _self = this;
            if(bool == true){
                if(this.type == 'error' || this.type == 'info'){
                    document.addEvent('keydown',function(event){
                        if(event.key == 'esc'){
                            event.stop();
                            _self.cancel();
                        }
                        else if(event.key == 'enter'){
                            event.stop();
                            _self.enter();
                        }
                    });
                }else if(this.type == 'confrim'){
                    document.addEvent('keydown',function(event){
                        if(event.key == 'esc'){
                            event.stop();
                            _self.cancel();
                        }
                    });
                };
            }else{
                document.removeEvents('keydown');
            }
        }
    };

    helpIcon = {
        'createHTML':function(){
            this.helpLink = new Element('a',{
                'id':'helpIcon',
                'class':'helpIcon',
                'target':'_blank',
                'href':'/user/feedback',
                'html':'帮助反馈'
            });

            this.helpLink.inject(document.getElement('body'));
        },
        'move':function(){
            if(this.mask) return;
            $clear(this.timeout);
            this.mask = true;
            var _self = this;
            this.Tween = new Fx.Tween(this.helpLink,{
                'link':'cancel'
            }).addEvent('complete',function(){
                _self.mask = false;
                _self.Tween.removeEvents('complete');
                _self.timeout = setTimeout(function(){
                    _self.Tween.start('right',-83);
                },2000);
            }).start('right',0);
        },
        'init':function(){
            var _self = this;
            this.createHTML();
            _self.move();
            document.addEvents({
                'mousemove':function(){
                    _self.move();
                },
                'mousewheel':function(){
                    _self.move();
                }
            });
        }
    }

//学习平台图标提示
personMenu = {
    'init':function(){
		var _self = this;
        this.menuList = $('personMenu');
        if(!this.menuList) return;
        this.linkArray = this.menuList.getChildren();
        this.fxArray = this.linkArray.getElements('div');
        this.linkArray.each(function(item,index){
			//if(!item.hasClass('info')){
				var div = item.getElement('div');
				var timeout;
				item.addEvents({
					'mouseenter':function(){
						timeout = setTimeout(function(){
							div.setStyle('display','');
						},500);

					},
					'mouseleave':function(){
						$clear(timeout);
						div.setStyle('display','none');
					}
				});
			//};
        });
		
		setTimeout(function(){
			_self.linkArray[1].getElement('div').setStyle('display','');
		},1000)
		
		setTimeout(function(){
			_self.linkArray[1].getElement('div').setStyle('display','none');
		},5000)
		
		setTimeout(function(){
			_self.linkArray[1].getElement('div').setStyle('display','');
		},6000)
		
		setTimeout(function(){
			_self.linkArray[1].getElement('div').setStyle('display','none');
		},11000)
    }
}

//列表页左右高度平衡调整
leftRightBalance = {
    init:function(){
        console.log("leftRightBalance-init")
        this.leftCon = $('leftCon');
        this.rightCon = $('rightCon');

        if(!this.leftCon || !this.rightCon) return;

        var left = this.getLeftAllHeight();
        var right = this.getRightAllHeight();
        console.log(left);
        console.log(right);

        if(left < 600 && right < 600)
        {
            console.log('===')
            this.setLeftHeight(600);
            this.setRightHeight(600);
        }else if(left > right)
        {
            console.log('==left')
            this.setLeftHeight(left);
            this.setRightHeight(left);
        }else if(right > left)
        {
            console.log('==right')
            this.setLeftHeight(right);
            this.setRightHeight(right);
        };

    },
    getLeftAllHeight : function(){
        return this.leftCon.getSize().y;
    },

    setLeftHeight : function(px){
        //if(this.indentify == 'noTitle'){
            this.leftCon.setStyle('height',(px + 20) + 'px');
        /* }else{
            this.leftCon.setStyle('height',(px + 20) + 'px');
        }; */
        if(this.leftCon.getElement('h3')){
            if( this.leftCon.getElements('ul').lenght == 1)this.leftCon.getElement('ul').setStyle('height',(px - 20) + 'px');
        }else{
            if( this.leftCon.getElements('ul').lenght == 1)this.leftCon.getElement('ul').setStyle('height',(px + 12) + 'px');
        };
    },

    getRightAllHeight : function(){
        var height = 0;
        this.rightCon.getChildren().each(function(item){
            height += item.getSize().y;
        });
        return height;
    },

    setRightHeight : function(px){
        this.rightCon.setStyle('height',px + 'px');
    }
}

//激活码验证
actionCode = {
    'init':function(){
        var _self = this;
        this.activeCodeForm = $('activeCodeForm');
        this.activeCodeInput = $('activeCodeInput');
        this.activeCodeForm.addEvent('submit',function(event){
            event.stop();
            _self.check();
        });
    },
    'check':function(){
        if(this.activeCodeInput.get('value').trim().length == 0){
            this.setError('请输入激活码');
            return;
        };

        this.activeCodeForm.submit();
    },
    'setError':function(text){
        if(!this.activeCodeSysInfo) this.activeCodeSysInfo = $('activeCodeSysInfo');
        this.activeCodeSysInfo.setStyle('display','').innerHTML = text;
    }
}

//系统提示
sysInfo = {
    setError : function(text){
        this.init();
        this.sysinfoDom.addClass('wrongInfo').setStyle('display','').innerHTML = text;
    },
    init : function(){
        if(!this.sysinfoDom) this.sysinfoDom = $('sysInfo');
    }
};

//其他需要domready加载想
domReadyLoad = {
    init : function(){
        $$('.play_wareicon, .pub_wareicon, .wareIcon, .cPic').each(function(item){
            item.addEvents({
                'mouseenter':function(){
                    item.getElement('.mask').setStyle('opacity',0);
                    item.getElement('.play').setStyle('display','');
                },
                'mouseleave':function(){
                    item.getElement('.mask').setStyle('opacity',0.5).setStyle('visibility','');
                    item.getElement('.play').setStyle('display','none');
                }
            })
        });

        var pager_currentpage = $('pager_currentpage');
        if(pager_currentpage){
            pager_currentpage.addEvent('keydown',function(evnet){
                if(evnet.key == 'enter'){
                    var currentpage = pager_currentpage.value.toInt();
                    if(/^[1-9]*$/.test(currentpage)){
                        var totalpage = $('totalpage').get('html').toInt();
                        if(currentpage > totalpage){
                            currentpage = totalpage;
                        };
                            currentpage = (currentpage-1)*10;
                        URL.setQuery({
                            'start':currentpage
                        });
                    };
                }

            });
        };
    }
};

//平台首页焦点图
//平台首页焦点图
homefocusImage = {
    init : function(){
        var _self = this;
        this.focusImgList = $('focusImgList');
        this.focusImgList.setStyle('position','relative');
        this.focusChangeButton = $('focusChangeButton');
        this.focusImgItems = this.focusImgList.getChildren();
        this.focusChangeButtons = this.focusChangeButton.getChildren();
        this.runIndex = 0;
        this.timeoutIndex = 0;
        this.standardIndex = 1000;
        this.fxs = [];

        this.focusChangeButtons.each(function(item,index){
            item.addEvents({
                'mouseover':function(){
                    $clear(_self.timeoutIndex);
                    _self.runIndex = index
                    _self.change(_self.runIndex,true);
                },
                'mouseout':function(){
                    _self.loop();
                }
            });
        });

        this.focusImgItems.each(function(item,index){
            item.setStyles({
                'position':'absolute',
                'left':0,
                'right':0,
                'display':'',
                'z-index':_self.standardIndex - index
            });
            _self.fxs.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        });

        this.loop();
    },
    change : function(index,now){
        this.setIndex(index);
        if(now){
            this.focusImgItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0);
        }else{
            this.fxs[this.per].start(1, 0);
        };


        this.focusChangeButtons.each(function(item){
            item.removeClass('current');
        });

        this.focusChangeButtons[index].addClass('current');

    },
    setIndex : function(current){
        this.focusImgItems.each(function(item){
            item.setStyle('z-index',0)
        });

        this.per = 0;
        if(current - 1 < 0){
            this.per = this.focusImgItems.length - 1;
        }else{
            this.per = current - 1;
        }

        this.focusImgItems[current].setStyle('z-index',this.standardIndex - 1).setStyle('opacity',1);
        this.focusImgItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',1);
    },

    loop : function(){
        var _self = this;
        this.runIndex++;

        if(this.runIndex > this.focusImgItems.length - 1){
            this.runIndex = 0;
        };

        this.timeoutIndex = setTimeout(function(){
            _self.change(_self.runIndex);
            _self.loop();
        },4000);




    }
}

//机关首页焦点图
jgHomefocusImage = {
    init : function(){
        var _self = this;
        this.focusImgList = $('focusImgList');
        this.detailList = $('detailList');
        this.focusImgList.setStyle('position','relative');
        this.focusChangeButton = $('focusChangeButton');

        this.focusImgItems = this.focusImgList.getChildren();
        this.detailItems = this.detailList.getChildren();
        this.focusChangeButtons = this.focusChangeButton.getChildren();
        this.runIndex = 0;
        this.timeoutIndex = 0;
        this.standardIndex = 1000;
        this.fxs = [];
        this.fxds = [];

        this.focusChangeButtons.each(function(item,index){
            item.addEvents({
                'mouseover':function(){
                    $clear(_self.timeoutIndex);
                    _self.runIndex = index
                    _self.change(_self.runIndex,true);
                },
                'mouseout':function(){
                    _self.loop();
                }
            });
        });

        this.focusImgItems.each(function(item,index){
            item.setStyles({
                'position':'absolute',
                'left':0,
                'right':0,
                'display':'',
                'z-index':_self.standardIndex - index
            });
            _self.fxs.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        });

        this.detailItems.each(function(item,index){
            item.setStyles({
                'z-index':_self.standardIndex - index
            });
            _self.fxds.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        });

        this.loop();
    },
    change : function(index,now){
        this.setIndex(index);
        if(now){
            this.focusImgItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0);
            this.detailItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0);
        }else{
            this.detailItems[index].setStyle('opacity',0);
            this.fxs[this.per].start(1, 0);
            this.fxds[this.per].start(1, 0);
            this.fxds[index].start(0, 1);
        };


        this.focusChangeButtons.each(function(item){
            item.removeClass('current');
        });

        this.focusChangeButtons[index].addClass('current');

    },
    setIndex : function(current){
        this.focusImgItems.each(function(item){
            item.setStyle('z-index',0)
        });

        this.per = 0;
        if(current - 1 < 0){
            this.per = this.focusImgItems.length - 1;
        }else{
            this.per = current - 1;
        }

        this.focusImgItems[current].setStyle('z-index',this.standardIndex - 1).setStyle('opacity',1);
        this.focusImgItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',1);

        this.detailItems[current].setStyle('z-index',this.standardIndex - 1).setStyle('opacity',1);
        this.detailItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',1);
    },

    loop : function(){
        var _self = this;
        this.runIndex++;

        if(this.runIndex > this.focusImgItems.length - 1){
            this.runIndex = 0;
        };

        this.timeoutIndex = setTimeout(function(){
            _self.change(_self.runIndex);
            _self.loop();
        },4000);




    }
}

//机关首页焦点图
jgHomefocusImage2 = {
    init : function(){
        var _self = this;
		this.focusMinImgList = $('focusMinImgList');
        this.focusMaxImgList = $('focusMaxImgList');
        //this.detailList = $('detailList');
        //this.focusImgList.setStyle('position','relative');
        //this.focusChangeButton = $('focusChangeButton');

        this.focusMinImgListItems = this.focusMinImgList.getChildren();
		this.focusMaxImgListItems = this.focusMaxImgList.getChildren();
        //this.detailItems = this.detailList.getChildren();
        //this.focusChangeButtons = this.focusChangeButton.getChildren();
        this.runIndex = 0;
        this.timeoutIndex = 0;
        this.standardIndex = 1000;
        this.fxs = [];
        this.fxds = [];

        this.focusMinImgListItems.each(function(item,index){
            item.addEvents({
                'mouseover':function(){
                    $clear(_self.timeoutIndex);
                    _self.runIndex = index
                    _self.change(_self.runIndex,true);
                },
                'mouseout':function(){
                    _self.loop();
                }
            });
        });

        this.focusMaxImgListItems.each(function(item,index){
            item.setStyles({
                'position':'absolute',
                'left':0,
                'right':0,
                'display':'',
                'z-index':_self.standardIndex - index
            });
            _self.fxs.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        });

/*         this.detailItems.each(function(item,index){
            item.setStyles({
                'z-index':_self.standardIndex - index
            });
            _self.fxds.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        }); */

        this.loop();
    },
    change : function(index,now){
        this.setIndex(index);
        if(now){
            this.focusMaxImgListItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0);
            //this.detailItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0);
        }else{
            //this.detailItems[index].setStyle('opacity',0);
            this.fxs[this.per].start(1, 0);
            //this.fxds[this.per].start(1, 0);
            //this.fxds[index].start(0, 1);
        };


        this.focusMinImgListItems.each(function(item){
            item.getElement('.imgcover').removeClass('current');
        });

        this.focusMinImgListItems[index].getElement('.imgcover').addClass('current');

    },
    setIndex : function(current){
        this.focusMaxImgListItems.each(function(item){
            item.setStyle('z-index',0)
        });

        this.per = 0;
        if(current - 1 < 0){
            this.per = this.focusMaxImgListItems.length - 1;
        }else{
            this.per = current - 1;
        }

        this.focusMaxImgListItems[current].setStyle('z-index',this.standardIndex - 1).setStyle('opacity',1);
        this.focusMaxImgListItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',1);
    },

    loop : function(){
        var _self = this;
        this.runIndex++;

        if(this.runIndex > this.focusMaxImgListItems.length - 1){
            this.runIndex = 0;
        };

        this.timeoutIndex = setTimeout(function(){
            _self.change(_self.runIndex);
            _self.loop();
        },4000);




    }
}

//机关首页焦点图
jgHomefocusImage3 = {
    init : function(){
        var _self = this;
        this.focusImgList = $('focusImgList');
        this.detailList = $('detailList');
        this.focusImgList.setStyle('position','relative');
        this.focusChangeButton = $('focusChangeButton');

        this.focusImgItems = this.focusImgList.getChildren();
		this.detailItems = this.detailList.getChildren();
        this.focusChangeButtons = this.focusChangeButton.getChildren();
        this.runIndex = 0;
        this.timeoutIndex = 0;
        this.standardIndex = 1000;
        this.fxs = [];
        this.fxds = [];

        this.focusChangeButtons.each(function(item,index){
            item.addEvents({
                'mouseover':function(){
                    $clear(_self.timeoutIndex);
                    _self.runIndex = index
                    _self.change(_self.runIndex,true);
                },
                'mouseout':function(){
                    _self.loop();
                }
            });
        });

        this.focusImgItems.each(function(item,index){
            item.setStyles({
                'position':'absolute',
                'left':0,
                'right':0,
                'display':'',
                'z-index':_self.standardIndex - index
            });
            _self.fxs.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        });

		this.detailItems.each(function(item,index){
            item.setStyles({
                'z-index':_self.standardIndex - index
            });
            _self.fxds.push(new Fx.Tween(item, {
                'duration': 1000,
                'link': 'cancel',
                'property': 'opacity'
            }))
        });

        this.loop();
    },
    change : function(index,now){
        this.setIndex(index);
        if(now){
            this.focusImgItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0)
            this.detailItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',0).setStyle('display','');
        }else{
            this.detailItems[index].setStyle('opacity',0);
			this.focusImgItems[this.per].setStyle('display','');
            this.fxs[this.per].start(1, 0);
            this.fxds[this.per].start(1, 0);
            this.fxds[index].start(0, 1);
        };


        this.focusChangeButtons.each(function(item){
            item.removeClass('current');
        });

        this.focusChangeButtons[index].addClass('current');

    },
    setIndex : function(current){
        this.focusImgItems.each(function(item){
            item.setStyle('z-index',0)
        });
		
		this.detailItems.each(function(item,index){
			 item.setStyle('display','none');
        });		

        this.per = 0;
        if(current - 1 < 0){
            this.per = this.focusImgItems.length - 1;
        }else{
            this.per = current - 1;
        }

        this.focusImgItems[current].setStyle('z-index',this.standardIndex - 1).setStyle('opacity',1);
        this.focusImgItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',1);

        this.detailItems[current].setStyle('z-index',this.standardIndex - 1).setStyle('opacity',1).setStyle('display','');
        this.detailItems[this.per].setStyle('z-index',this.standardIndex).setStyle('opacity',1).setStyle('display','');
    },

    loop : function(){
        var _self = this;
        this.runIndex++;

        if(this.runIndex > this.focusImgItems.length - 1){
            this.runIndex = 0;
        };

        this.timeoutIndex = setTimeout(function(){
            _self.change(_self.runIndex);
            _self.loop();
        },4000);




    }
}

//选项卡
tagList = {
    init:function(){
        var _self = this;
        this.tagList = $('tagList').getChildren();
        this.tagItems = $('tagItems').getChildren();
        this.tagList.each(function(item,index){
            item.addEvent('mouseenter',function(){
                _self.tagList.each(function(initem,inindex){
                    initem.removeClass('current');
                    _self.tagItems[inindex].setStyle('display','none')
                });
                item.addClass('current');
                _self.tagItems[index].setStyle('display','')
            });

        });
    }
}

//设定底部边栏位置
setfooterPosition = {
    'init': function(){
        var clientHeight = document.documentElement.clientHeight;
        var bodyHeight = 0;
        var domBody = document.getElement('body');
        var bodyInnerDoms = domBody.getChildren()
        bodyInnerDoms.each(function(item){
            //console.log(item.getSize().y)
            bodyHeight +=item.getSize().y;
        });

        console.log('bodyHeight:' + bodyHeight)
        console.log('clientHeight:' + clientHeight)
		var setHeightDom = domBody.getChildren('.content')[0]|| domBody.getChildren('.wrap')[0];
        if(bodyHeight >= clientHeight){
			//setHeightDom.setStyle('height','');
			return;
		} 
        var distance =  clientHeight - bodyHeight;
        
        //var setHeightDom = domBody.getChildren('.wrap')[0];
        console.log('setHeightDom:' +setHeightDom)
        setHeightDom.setStyle('height', (setHeightDom.getSize().y - 20 + distance) + 'px');
/*         if(domBody.getChildren('.content')[0] === setHeightDom){
            domBody.getChildren('.content')[0].getChildren('.innerCon').setStyle('height', (setHeightDom.getSize().y - 20 + distance) + 'px');
        } */
        console.log('setfooterPosition-init')
    }
};

//报名确认
siguupConfirm = {
    init:function(){
        var _self = this;
        this.siguupButton = $('siguup');
        if(this.siguupButton){
            this.siguupButton.addEvent('click',function(event){
                event.stop();
                top.messageBox.setConfirm({
                    'content':'请您使用实际参加培训者的信息登录或注册,进行报名。',
                    'enter':function(){
                        location.href = _self.siguupButton.href;
                    },
                    'cancel':function(){
                    }}).display();
            });
        }
    }
}

//提示信息控制
infoSys = {
    'display':function(info,time){
        var _self = this;
        clearTimeout(this.setTimeout);
        this.getDom().setStyle('display','').innerHTML = info || '';
        if(time){
            this.setTimeout = setTimeout(function(){
                _self.getDom().setStyle('display','none');
            },time);
        };
    },
    'error':function(info,time){
        this.getDom().removeClass('warnInfo').removeClass('rightInfo').addClass('wrongInfo');
        this.display(info,time);
    },
    'alert':function(info,time){
        this.getDom().removeClass('wrongInfo').removeClass('rightInfo').addClass('warnInfo');
        this.display(info,time);
    },
    'info':function(info,time){
        this.getDom().removeClass('warnInfo').removeClass('wrongInfo').addClass('rightInfo');
        this.display(info,time);
    },
    'getDom':function(){
        if(!this.targetDom) this.targetDom = $('sysInfo');
        return this.targetDom;
    }
}

//首页课程清单动态
homeCList = {
	init : function(){
		new Fx.Accordion($('accordion'), '#accordion h3', '#accordion .itemlist',{
			'trigger':'mouseover',
			'onActive':function(toggler,element){
				$$('#accordion h3 .class1').each(function(item){
					item.removeClass('current');
				});
				toggler.getElement('.class1').addClass('current');
			}
		});
	}
}

//左侧列表课程分类指示
CSort = {
	'setCurrent':function(){
		var id = URL.getQuery('type');
		if(id){
			$('accordion').getElements('a').each(function(item){
				if(item.get('href').indexOf('type='+id) != -1){
					item.getParent().addClass('current');
				}
			})			
		};
	}
}

//滚动
scrollAny = new Class({
	'initialize':function(dom,decoration){
		var _self = this;
		this.dom = $(dom);
		this.size = 0;
		this.innerSize = 0;
		this.current = 0;
		this.dec = decoration == 'x' ? 'left' : 'top';
		if(decoration == 'x'){
			this.size = this.dom.getSize().x
			this.innerSize = this.dom.getElement('*').getSize().x;
		}else{
			this.size = this.dom.getSize().y
			this.innerSize = this.dom.getElement('*').getSize().y;	
		};
		if(this.innerSize > this.size){
			this.dom.setStyle('position','relative');
			this.condom = new Element('div',{
				'styles':{
					'position':'absolute',
					'top':0,
					'left':0				
				}
			});
			if(this.dec == 'left') this.condom.setStyle('width',(this.innerSize * 2) + 'px');
			this.domInnerHTML = this.dom.innerHTML + this.dom.innerHTML;
			this.dom.innerHTML = '';
			this.dom.adopt(this.condom);
			this.condom.innerHTML = this.domInnerHTML;
			this.dom.addEvents({
				'mouseenter':function(){
					_self.stop();
				},
				'mouseleave':function(){
					_self.start();
				}
			});
			this.start();
		}
		
		
	},
	'change':function(){
		var _self = this;
		if(this.current < this.innerSize){
			this.condom.setStyle(this.dec, '-'+(++this.current)+'px');
		}else{
			this.current = 0;
			this.condom.setStyle(this.dec, this.current + 'px');
		};
		this.setTimeout = setTimeout(function(){
			_self.change();
		},100);
	},
	
	'start':function(){
		this.change();
	},
	
	'stop':function(){
		$clear(this.setTimeout);
	}
	
	})

hualu5 = {
	'func':{
		'moviePlayer' : {
			'onLoad':function(){
				this.callEvent('onLoad');
			},
			'onFinish': function(){
				this.callEvent('onFinish');
			},
			'onStart':function(){
				this.callEvent('onStart');
			},
			'onEnd':function(){
				this.callEvent('onEnd');
			},
			'onPause':function(){
				this.callEvent('onPause');
			},
			'onPlay':function(){
				this.callEvent('onPlay');
			},
			'openLight' :function(){
				this.callEvent('openLight');
			},
			'closeLight':function(){
				this.callEvent('closeLight');
			},
			'setSize':function(width,height){
				console.log('width:' + width + '   height:' + height)
/* 				try{
					var flashOjbect = $('_FlashPlayer');
					flashOjbect.width = width;
					flashOjbect.height = height;
					flashOjbect.style.margin ='0 auto';
					var flashCon = $$('._FlashPlayer')[0];
					flashCon.style.height = height;
				}catch(e){
					
				} */
			},
			//数据储存
			eventData : {
				'onLoad':[],
				'onFinish':[],
				'onStart':[],
				'onEnd':[],
				'onPause':[],
				'onPlay':[],
				'openLight':[],
				'closeLight':[]
			},
			//事件调用
			callEvent : function(type){
				if(this.eventData[type]){
					this.eventData[type].each(function(item){
						item();
					});
				}
			},
			//添加事件调用
			addFunction : function(type,fn){
				if(this.eventData[type]){
					this.eventData[type].push(fn);
				}
			}
		}	
	}
};

//图片加载完成触发leftRightBalance
imgLoad = {
	'init':function(){
		this.rightCon = $('rightCon');
		if(!this.rightCon) return;
		this.rightCon.getElements('img').each(function(item){
			item.addEvent('load',function(){
				//leftRightBalance.init();  //----2013-3-13 linfang 列表长度有问题，去掉多余加载
			})
		});
	}
}

//文件上传
uploadFile = new Class({
	initialize:function(options){
		var _self = this;
		this.options = options;
		this.options.action = this.options.action;
		this.options.button_Con = this.options.button_Con;
		this.options.flash_path = this.options.flash_path;
		this.options.images_path = this.options.images_path;
		this.options.file_types = this.options.file_types || "*.*";
		this.options.file_size_limit = this.options.file_size_limit || "2MB";
		this.options.file_upload_limit = this.options.file_upload_limi || 0;
		this.options.file_queue_limit = this.options.file_queue_limit || 0;
		this.options.buttonSize = this.options.buttonSize || {'width':'65','height':'24'};
		this.params = this.options.params ? this.options.params : {};
		this.events = this.options.events ? this.options.events : {};
		this.events.onSuccess  = this.events.onSuccess ? this.events.onSuccess : function(){};
		this.events.onProgress  = this.events.onProgress ? this.events.onProgress : function(){};
		this.events.onFailure  = this.events.onFailure ? this.events.onFailure : function(){};
		this.events.onLoad  = this.events.onLoad ? this.events.onLoad : function(){};
		this.paperswfUpload = new SWFUpload(this.paperImgSetData());
	},
	//上传相关事件
	paperImgSetData : function(){
		var _self = this;
		var settting = {
			flash_url : this.options.flash_path + "swfupload.swf",
			flash9_url : this.options.flash_path + "swfupload_fp9.swf",
			upload_url: this.options.action,
			post_params: this.options.params,
			file_size_limit : this.options.file_size_limit,
			file_types : this.options.file_types,
			file_upload_limit : this.options.file_upload_limit,
			file_queue_limit : this.options.file_queue_limit,
			
			// Button settings
			button_image_url: this.options.images_path,
			button_width: this.options.buttonSize.width,
			button_height: this.options.buttonSize.height,
			button_placeholder_id:this.options.button_Con,
			button_cursor:SWFUpload.CURSOR.HAND,		
			
			//加载成功
			swfupload_loaded_handler : function(){
				console.log('swfupload_loaded_handler');
				_self.events.onLoad();
			},
			//对话框打开前
			file_dialog_start_handler : function(){
				console.log('file_dialog_start_handler')
			},
			//对话框关闭后
			file_queued_handler : function(){
				console.log('file_queued_handler')
			},
			//加入队列失败
			file_queue_error_handler : function(){
				console.log('file_queue_error_handler')
				top.messageBox.setError({'content':'文件不能大于'+_self.options.file_size_limit}).display();
			},
			//加入队列完成
			file_dialog_complete_handler : function(){
				console.log('file_dialog_complete_handler')
				this.startUpload();
			},
			//开始上传前
			upload_start_handler : function(){	
				console.log('upload_start_handler');
			},
			
			//上传中触发
			upload_progress_handler : function(fileobject, bytescomplete, totalbytes){
				console.log('upload_progress_handler');
				console.log(bytescomplete);
				_self.events.onProgress(fileobject, bytescomplete, totalbytes)
				
			},
			
			//上传错误
			upload_error_handler : function(fileobject, errorcode, message){
				console.log('upload_error_handler')
				console.log(errorcode);
				this.setButtonDisabled(false);
				this.setButtonImageURL(_self.options.images_path);
				if(errorcode == '240'){
					top.messageBox.setError({'content':'上传失败,请重新上传'}).display();
				};
				_self.events.onFailure(fileobject, errorcode, message)
			},
			
			//上传成功
			upload_success_handler : function(fileobject, serverdata){
				console.log('upload_success_handler');
				console.log(serverdata);
				this.setButtonDisabled(false);
				this.setButtonImageURL(_self.options.images_path);
				_self.events.onSuccess(fileobject, serverdata);
			},

			//上传一个文件完成
			upload_complete_handler : function(){
				console.log('upload_complete_handler');
			}
		};		
		return settting;
	}	
});


addressBook = {
	'init':function(){
		var _self = this;
		this.callCardForm = $('callCardForm');
		this.callCardInput =  $('callCardInput');
		var defaultText = '输入学员姓名或单位名称';
		if(this.callCardInput.get('value').trim().length == 0){
			this.callCardInput.set('value',defaultText).setStyle('color','#848484');
		};
		
		this.callCardInput.addEvents({
			'focus':function(){
				if(_self.callCardInput.get('value').trim() == defaultText){
					_self.callCardInput.set('value','').setStyle('color','#000');
				}
			},
			'blur':function(){
				if(_self.callCardInput.get('value').trim() == defaultText || _self.callCardInput.get('value').trim().length == 0){
					_self.callCardInput.set('value',defaultText).setStyle('color','#848484');
				}				
			}
		});
		
		this.callCardForm.addEvent('submit',function(event){
			event.stop();
			if(_self.callCardInput.get('value').trim() == defaultText){
				_self.callCardInput.set('value','');
			};
			_self.callCardForm.submit();
		})
		
		
	}
}

//JSONCookie
JSONCooKie = {
	get:function(name){
		var data = Cookie.read('jsonData');
		if(data != null){
			data = JSON.decode(data);
			if(data[name]){
				return data[name];
			}else{
				return null;
			}
		}else{
			return null;
		}
	},
	set:function(name,value){
		var data = Cookie.read('jsonData');
		if(data == null){
			Cookie.write('jsonData','{}',{'duration':3650});
			data = '{}';
		};
		data = JSON.decode(data);
		data[name] = value;
		Cookie.write('jsonData',JSON.encode(data));
	}	
}

//公告板打开关闭功能
noticeDisplay = {
	'init':function(){
		var _self = this;
		this.noticeContent = $('noticeContent');
		this.noticeDisplayButton = $('noticeDisplayButton');
		this.set(JSONCooKie.get('noticeDisplay') ? JSONCooKie.get('noticeDisplay') : false);
		this.noticeDisplayButton.addEvent('click',function(){
			_self.set(_self.setState());
		});
	},
	'set':function(value){
		if(value){
			JSONCooKie.set('noticeDisplay',value);
			this.noticeContent.setStyles({
				'overflow-x':'hidden',
				'overflow-y':'hidden',
				'height':'auto'	
			});
			
			this.noticeDisplayButton.removeClass('open').addClass('close').innerHTML = '恢复折叠';
			var setHeightDom = document.getElement('body').getChildren('.content')[0]|| document.getElement('body').getChildren('.wrap')[0];
			setHeightDom.setStyle('height','auto');
		}else{
			JSONCooKie.set('noticeDisplay',value);
			this.noticeContent.setStyles({
				'overflow-x':'hidden',
				'overflow-y':'scroll',
				'height':'230px'	
			});

			this.noticeDisplayButton.removeClass('close').addClass('open').innerHTML = '展开全部';
			setfooterPosition.init();
		};
	},
	'getState':function(){
		return JSONCooKie.get('noticeDisplay') ? JSONCooKie.get('noticeDisplay') : false;
	},
	
	'setState':function(){
		return JSONCooKie.get('noticeDisplay') ? false : true;
	}
}

//页面报错提交
reportError = new Class({
	'initialize':function(errorcontent){
		this.errorcontent = errorcontent
	},
	'paramFormat':function(){
		var data = {};
		data['用户ID'] = Cookie.read('remenber_email') ? Cookie.read('remenber_email') : 'anonymous';
		data['浏览器信息'] = navigator.userAgent;
		data['URL信息'] = location.href;
		data['屏幕信息'] = window.screen.width + 'x' + window.screen.height +' '+window.screen.colorDepth;
		data['Flash版本'] = Browser.Plugins.Flash ? Browser.Plugins.Flash.build : 'non';
		if(this.errorcontent) data['其他'] = this.errorcontent;
	}
});

//加入收藏夹，兼容多种浏览器
function AddFavorite(sURL,sTitle){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.indexOf("msie 8")>-1){//IE8浏览器，使用AddToFavoritesBar函数
        window.external.AddToFavoritesBar(sURL,sTitle,'slice');//IE8
    }else{
        try{
            window.external.addFavorite(sURL,sTitle);//针对其他ie
        }catch(e){
            try{
                window.sidebar.addPanel(sTitle,sURL,"");
            }catch(e){
                alert("加入收藏失败，请使用Ctrl+D进行添加");
            }
        }
    }
}
//设置为首页
function SetHome(obj,vrl){
    try{obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);}
    catch(e){
        if(window.netscape) {
            try {netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");}
            catch (e) {alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");}
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage',vrl);
         }
    }
}

document.addEvent('domready',function(){
	imgLoad.init();
    personMenu.init();
    leftRightBalance.init();
    domReadyLoad.init();
    setfooterPosition.init();
});
