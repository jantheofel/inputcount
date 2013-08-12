/**
 * PHP version 5
 * @copyright  Jan Theofel 2012, ETES GmbH 2009
 * @author     Jan Theofel <jan@theofel.de>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 *
 * COMPRESS WITH http://jscompress.com/ 
 * THEN RENAME BACK CLASS NAME
 */

(function($){ 

var InputCount = new Class(
{
	showMessage: function(obj, message)
	{
		if(!obj.element) {
			var pos = obj.getCoordinates().right;
			var options = {
				'opacity' : 0,
				'position' : 'absolute',
				'float' : 'left',
				'left' : pos + -45
			}
			obj.element = new Element('div', {'class' : 'ic-tbx', 'styles' : options}).inject(document.body);
//			this.addPositionEvent(obj);
		}
		if (obj.element) {
			obj.element.empty();
			var messages = [];
			
			if (Element.setHTML)
			{
				messages.push(new Element('p').setHTML(message));
			}
			else
			{
				messages.push(new Element('p').set('html', message));
			}
			
			var tips = this.makeTips(messages).inject(obj.element);
/*			if(this.options.display.closeTipsButton) {
				tips.getElements('a.close').addEvent('mouseup', function(){
					this.removeError(obj);
				}.bind(this));
			}*/
			obj.element.setStyle('top', obj.getCoordinates().top - tips.getCoordinates().height);
			
			if (!window.ie7 && obj.element.getStyle('opacity') == 0)
			{
				if (Fx.Styles)
				{
					new Fx.Styles(obj.element, {'duration' : 300}).start({'opacity':[1]});
				}
				else
				{
					new Fx.Morph(obj.element, {'duration' : 300}).start({'opacity':[1]});
				}
			}
			else
			{
				obj.element.setStyle('opacity', 1);
			}
		}
	},
	
	hideMessage: function(el)
	{
		el.element.empty();
	},
	
	
	/*
	Function: makeTips
		Private method
		
		Create tips boxes
	*/
	makeTips : function(txt) {
		var table = new Element('table');
			table.cellPadding ='0';
			table.cellSpacing ='0';
			table.border ='0';
			
			var tbody = new Element('tbody').inject(table);
				var tr1 = new Element('tr').inject(tbody);
					new Element('td', {'class' : 'tl'}).inject(tr1);
					new Element('td', {'class' : 't'}).inject(tr1);
					new Element('td', {'class' : 'tr'}).inject(tr1);
				var tr2 = new Element('tr').inject(tbody);
					new Element('td', {'class' : 'l'}).inject(tr2);
					var cont = new Element('td', {'class' : 'c'}).inject(tr2);
						var errors = new Element('div', {'class' : 'err'}).inject(cont);
						txt.each(function(error) {
							error.inject(errors);
						});
//						if (this.options.display.closeTipsButton) new Element('a',{'class' : 'close'}).inject(cont);
					//	new Element('div', {'style' : "clear:both"}).inject(cont);
					new Element('td', {'class' : 'r'}).inject(tr2);
				var tr3 = new Element('tr').inject(tbody);
					new Element('td', {'class' : 'bl'}).inject(tr3);
					new Element('td', {'class' : 'b'}).inject(tr3);
					new Element('td', {'class' : 'br'}).inject(tr3);			
		return table;
	}
});

  window.InputCount = InputCount;

})(document.id);
