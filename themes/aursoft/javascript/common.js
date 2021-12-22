if(typeof(Ext)!='undefined'){
    Ext.applyIf(String, {

        escape : function(string) {
            return string.replace(/('|\\)/g, "\\$1");
        },

        leftPad : function (val, size, ch) {
            var result = new String(val);
            if(!ch) {
                ch = " ";
            }
            while (result.length < size) {
                result = ch + result;
            }
            return result.toString();
        },


        format : function(format){
            var args = Array.prototype.slice.call(arguments, 1);
            return format.replace(/\{(\d+)\}/g, function(m, i){
                return args[i];
            });
        }
    });    
}










