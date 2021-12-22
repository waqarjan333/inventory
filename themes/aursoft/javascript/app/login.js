   Ext.onReady(function(){  
       
    var login = new Ext.FormPanel({ 
        labelWidth:80,
        url:url_login, 
        frame:true, 
        layout:'absolute',
        title:label_title, 
        defaultType:'textfield',
	monitorValid:true,
        defaults:{
          listeners: {
               specialkey: function(field, event){
                 if (event.getKey() == event.ENTER) {
                     if(field.up('form').getForm().isValid()){
                        login_submit();
                     }
                 }
               }
            }  
        },
        items:[{ 
                fieldLabel:label_username, 
                name:'username', 
                id:'username',
                cls:'label-table',
                style:'font-size:20px',
                x:120,
                y:50,
                width:255,
                allowBlank:false 
            },{ 
                fieldLabel:label_password, 
                name:'password', 
                cls:'label-table',
                inputType:'password', 
                style:'font-size:20px;',
                x:120,
                y:80,
                width:255,
                allowBlank:false 
         },
            {
              xtype: 'box',
              autoEl: { tag: 'div', html: login_text,cls:'company-name'},
              style: 'font-size: 20px;',
              x: 120,
              y: 8,
              height:21,
              width:131
            }
            ,
            {
              xtype: 'box',
              autoEl: { tag: 'div', html: '',cls:'inventory_logo'},
              width:97,
              height:80,
              x: 10,
              y: 8
            }, {
              xtype: 'button',
              name: 'login',
              text: button_login,
              width: 80,
              x: 295,
              y: 130,
              formBind: true,
               handler:function(){ 
                 login_submit();
               } 
            },{
                xtype: 'box',
                id: 'forget_password',
                autoEl: {
                    tag: 'a',
                    html: 'Forget Password',
                    style: 'font-weight: bold; color:#264888;margin-top:170px; margin-left:295px;',
                    href:forgetPassword
                },
                listeners: { 
                    el: {
                    
                }
                }
            }
        ]
    });
   function login_submit(){
       login.getForm().submit({ 
            method:'POST', 
            waitTitle:'Connecting', 
            waitMsg:'Sending data...',
            success:function(form,action){ 
                  var obj = Ext.JSON.decode(action.response.responseText);    
                  if(obj.success && obj.success===true){
                    if(obj.type=="1"){
                        window.location = url_pos;
                    } 
                    else{
                        window.location = url_home;
                    }
                  }

            }, 
            failure:function(form, action){ 
                if(action.failureType == 'server'){ 
                    var obj = Ext.JSON.decode(action.response.responseText); 
                    Ext.Msg.alert('Login Failed!', obj.errors.reason); 
                }else{ 
                    Ext.Msg.alert('Warning!', 'Authentication server is unreachable : ' + action.response.responseText); 
                } 
                login.getForm().reset(); 
            } 
        }); 
   } 
    var  win = new Ext.Window({
      layout:'fit',
      closable: false,
      draggable: false,
      resizable: false,
      width: 425,
      height:250,
      plain: true,
      border: false,
      bbar: [{
        border:false,
        borderBoyd:false,
        xtype: 'tbtext',
        text: copy_right_text
      }],
      items: [ login ]
    });
    win.show();
    Ext.getCmp("username").focus(true,true);
    //On ready end
});