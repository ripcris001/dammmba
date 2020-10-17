
let toaster = {
   text:"",
   class: "",
   success: function(message = ""){
      this.text = message;
      this.class = "card-alert card gradient-45deg-green-teal";
      this.trigger();
   },
   error: function(message = ""){
      this.text = message;
      this.class = "card-alert card gradient-45deg-red-pink";
      this.trigger();
   },
   warning: function(message = ""){
      this.text = message;
      this.class = "card-alert card gradient-45deg-green-teal";
      this.trigger();
   },
   info: function(message = ""){
      this.text = message;
      this.class = "card-alert card gradient-45deg-green-teal";
      this.trigger();
   },
   toast: function(message = "", cClass = false){
      this.text = message;
      this.class = "card-alert card gradient-45deg-green-teal";
      if(cClass){
         this.class = cClass;
      }
      this.trigger();
   },
   trigger: function(){
      const that = this;
      M.toast({
         html: that.text,
         classes: that.class
     })
   }
}

const request = {
   post : async function(data){
      let req = await $.post(data.url, data.body).done();
      console.log(req);
      if(req){
         req = JSON.parse(req);
         if(!req.status && req.code){
            if(req.code == 'PERMISSIONERROR'){
               toaster.error(req.message);
            }else if(req.code == 'PERMISSIONERROR'){
               toaster.warning(req.message);
            }
            return;
         }
      }
      return req;
   },
   get : async function(data){
      let req = await $.get(data.url, data.body).done();
      if(req){
         req = JSON.parse(req);
         if(!req.status && req.code){
            if(req.code == 'PERMISSIONERROR'){
               toaster.error(req.message);
            }else if(req.code == 'PERMISSIONERROR'){
               toaster.warning(req.message);
            }
            return;
         }
      }
      return req;
   }
}

const system = {
   redirect : function(data){
      window.location.href = data;
   },
   urlReload : function(){
      window.location.reload();
   }
}

const loadSelect = function(data, options, noValue){
   let html = `<option disabled selected>${noValue}</option>`;
   if(data && data.length){
      const count = data.length;
      const opt = options.split(':');
      
      for(let a = 0; a < count; a++){
         const loopdata = data[a];
         html += `<option value="${loopdata[opt[0]]}">${loopdata[opt[1]]}</option>`;
      }
   }
   return html;
}

