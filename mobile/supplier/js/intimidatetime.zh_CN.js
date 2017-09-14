/* Simplified Chinese translation for Intimidatetime */
(function($) {
	$.intimidatetime.i18n['zh-CN'] = {
		format: 'yyyy-MM-dd HH:mm',
		units: {
			year: { 
					format: 'yyyy',
					label: '年'
				},
			month: { 
					format: 'MMM',
					label: '月',
					names: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
					namesAbbr: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']
				},
			day: { 
					format: 'd',
					label: '日',
					names: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
					namesAbbr: ['周日','周一','周二','周三','周四','周五','周六'],
					namesHead: ['日','一','二','三','四','五','六']
				},
			hour: {  
					format: 'HH',
					label: '小时',
					am: ['AM','A'],
					pm: ['PM','P']
				},
			minute: { 
					format: 'mm',
					label: '分钟'
				},
			second: { 
					format: 'ss',
					label: '秒钟'
				},
			millisecond: { 
					format: 'l',
					label: '微秒'
				},
			microsecond: { 
					format: 'c',
					label: '微秒'
				},
			timezone: { 
					format: 'z',
					label: '时区'
				}
		},
		rtl: false
	};
	$.intimidatetime.setDefaults($.intimidatetime.i18n['zh-CN']);
})(window.jQuery || window.Zepto || window.$);

