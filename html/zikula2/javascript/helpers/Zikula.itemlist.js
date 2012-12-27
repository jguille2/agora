// Copyright Zikula Foundation 2010 - license GNU/LGPLv3 (or at your option, any later version).
if(typeof(Zikula)=="undefined"){Zikula={}}Zikula.itemlist=Class.create({initialize:function(a,d){this.id=a;this.options={headerpresent:false,firstidiszero:false,sortable:true,recursive:false,quotekeys:false,inputName:"",afterInitialize:Prototype.emptyFunction,beforeAppend:Prototype.emptyFunction,afterAppend:Prototype.emptyFunction};Object.extend(this.options,d||{});this.lastitemid=Number(!this.options.firstidiszero)-1;var e=$(this.id).immediateDescendants().size();var g=0;if(this.options.headerpresent){g=1}var f=$(this.id).select(".itemid").max(function(h){return Number(h.innerHTML)});this.lastitemid=isNaN(f)?this.lastitemid:f;var b="#"+this.id+" .buttondelete";$$(b).invoke("observe","click",this.deleteitem.bindAsEventListener(this));if(this.options.sortable){if(this.options.recursive){var c={id:this.id,only:"z-sortable",listTag:"ol",inputName:this.options.inputName,onUpdate:this.itemlistrecolor.bind(this)};this.sortable=new Zikula.recursiveSortable(c)}else{Sortable.create(this.id,{only:"z-sortable",constraint:false,onUpdate:this.itemlistrecolor.bind(this)})}$A($(this.id).getElementsByClassName("z-sortable")).each(function(i){var h=i.id;Element.addClassName(h,"z-itemsort")})}if(e==g){this.appenditem()}},getnamefromid:function(c){var b=c.split("_");var a=b[0];b=b.slice(1);b.each(function(d){if(this.options.quotekeys&&d!=""){a+="['"+d+"']"}else{a+="["+d+"]"}}.bind(this));return a},itemlistrecolor:function(){Zikula.recolor(this.id,"listheader")},appenditem:function(){var a=$(this.id+"_emptyitem").cloneNode(true);this.lastitemid++;lastid=this.lastitemid;a.id="li_"+this.id+"_"+lastid;if($(a).hasClassName("z-odd")){$(a).removeClassName("z-odd");$(a).addClassName("z-even")}else{$(a).removeClassName("z-even");$(a).addClassName("z-odd")}$A(a.getElementsByClassName("listinput")).each(function(b){b.id=b.id.replace(/X/g,lastid);b.name=this.getnamefromid(b.id);if(this.id.endsWith("_")){this.id+=lastid}}.bind(this));$A(a.getElementsByTagName("button")).each(function(b){b.id=b.id.replace(/X/g,lastid)});$A(a.getElementsByClassName("itemid")).each(function(b){if(b.hasAttribute("id")){b.id=b.id.replace(/X/g,lastid)}if(b.hasAttribute("value")){b.writeAttribute("value",lastid)}b.update(lastid)});$(this.id).appendChild(a);a.down(".buttondelete").observe("click",this.deleteitem.bindAsEventListener(this));if(this.options.sortable){if(this.options.recursive){this.sortable.initNode(a)}else{Sortable.create(this.id,{only:"z-sortable",constraint:false,onUpdate:this.itemlistrecolor.bind(this)})}$A(document.getElementsByClassName("z-sortable")).each(function(c){var b=c.id;Element.addClassName(b,"z-itemsort")})}this.itemlistrecolor();return lastid},deleteitem:function(b){var a=b.findElement(".buttondelete");var c=a.id.replace("buttondelete","li");if($(c)){$(c).remove()}this.itemlistrecolor()}});Zikula.recursiveSortable=Class.create({initialize:function(){this.config=Object.extend({id:"",listTag:"ul",handler:null,onDragClass:"onDragClass",dropOnClass:"dropOnClass",dropAfterClass:"dropAfterClass",dropBeforeClass:"dropBeforeClass",dropAfterOverlap:[0.3,0.7],only:null,onUpdate:Prototype.emptyFunction,maxDepth:0,inputName:"order",nodeIdPattern:/^[^_\-](?:[A-Za-z0-9\-\_]*)[_](.*)$/,langLabels:{}},arguments[0]||{});this.config.only=[this.config.only].flatten();this.config.langLabels=Object.extend({maxdepthreached:Zikula.__("Maximum depth reached. Limit is: "),warnbeforeunload:Zikula.__("You have unsaved changes!")},this.config.langLabels);this.list=$(this.config.id).cleanWhitespace();this.list.select("li").each(this.initNode.bind(this));Draggables.addObserver(new Zikula.recursiveSortableObserver(this.list,this.config.onUpdate));this.unsaved=false;this.serialize()},initNode:function(a){if(this.isAccepted(a)){new Draggable(a,{handle:this.config.handler,onEnd:this.endDrag.bind(this),onStart:this.startDrag.bind(this),revert:true,endeffect:function(b){new Effect.Highlight(b)},scroll:window});Droppables.add(a,{accept:this.config.only,hoverclass:this.config.dropOnClass,overlap:"vertical",onDrop:this.dropNode.bind(this),onHover:this.hoverNode.bind(this)})}},isAccepted:function(a){return this.config.only.length==0||this.config.only.any(function(b){return a.hasClassName(b)})},getId:function(a){return Number(a.identify().match(this.config.nodeIdPattern)[1])},startDrag:function(a){this.dropCache={};a.element.addClassName(this.config.onDragClass)},endDrag:function(a){if(this.dropCache.lastElement){this.insertNode(a.element,this.dropCache.lastElement)}this.list.select("."+this.config.dropAfterClass).invoke("removeClassName",this.config.dropAfterClass);this.list.select("."+this.config.dropBeforeClass).invoke("removeClassName",this.config.dropBeforeClass);a.element.removeClassName(this.config.onDragClass)},hoverNode:function(c,b,a){this.list.select("."+this.config.dropAfterClass).invoke("removeClassName",this.config.dropAfterClass);this.list.select("."+this.config.dropBeforeClass).invoke("removeClassName",this.config.dropBeforeClass);if(a>this.config.dropAfterOverlap[1]){b.addClassName(this.config.dropBeforeClass);this.dropCache.lastElement=["before",b.identify()]}else{if(a<this.config.dropAfterOverlap[0]){b.addClassName(this.config.dropAfterClass);this.dropCache.lastElement=["after",b.identify()]}else{this.dropCache.element=b;b.removeClassName(this.config.dropAfterClass);b.removeClassName(this.config.dropBeforeClass)}}},dropNode:function(c,b,a){var d=false;if(b.hasClassName(this.config.dropAfterClass)){d=this.insertNode(c,["after",b])}else{if(b.hasClassName(this.config.dropBeforeClass)){d=this.insertNode(c,["before",b])}else{d=this.insertNode(c,["bottom",b])}}if(!d){return false}this.dropCache={}},insertNode:function(a,b){var f=$(b[1]),d=b[0],h=d=="bottom",k=$(a.up(this.config.listTag,0).identify());if(this.config.maxDepth>0){var e=this.countLevels(f,"up"),j=this.countLevels(a,"down"),i=e+j+Number(h)+1;if(i>this.config.maxDepth){alert(this.config.langLabels.maxdepthreached+this.config.maxDepth);this.dropCache={};return false}}if(h){var g=f.down(this.config.listTag,0);if(g==undefined){g=new Element(this.config.listTag);f.insert(g)}g.show();f=g}var c={};c[d]=a;f.insert(c);if(k.down("li")==undefined){k.remove()}this.unsaved=true;this.serialize();return true},countLevels:function(c,e,a){var d=0;if(e=="up"){a=(a==undefined)?this.list:a;var b=c.ancestors();d=a.select(this.config.listTag).select(function(f){return b.include(f)}).size()}else{if(e=="down"){d=c.select("li").max(function(f){return this.countLevels(f,"up",c)}.bind(this))}}return isNaN(d)?0:d},serialize:function(){this.saved=new Hash();this.list.select("li").each(function(b){if(this.isAccepted(b)){var a=new Hash();a.set("parentid",(b.up("li")!=undefined)?this.getId(b.up("li")):null);a.set("haschildren",(b.down("li")!=undefined)?true:false);this.saved.set(this.getId(b),a)}}.bind(this));$(this.config.inputName).value=Object.toJSON(this.saved.toJSON());return this.saved},beforeUnloadHandler:function(a){if(this.unsaved&&this.config.langLabels.warnbeforeunload){return a.returnValue=this.config.langLabels.warnbeforeunload}return false}});Zikula.recursiveSortableObserver=Class.create({initialize:function(a,b){this.list=$(a);this.func=b},onEnd:function(){this.func(this.list)}});