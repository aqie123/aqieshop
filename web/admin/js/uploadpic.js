      $(function() {
        var objUrl;
        var img_html;
        $("#myFile").change(function() {
          var img_div = $(".img_div");
          var filepath = $("input[name='myFile']").val();
          for(var i = 0; i < this.files.length; i++) {
            objUrl = getObjectURL(this.files[i]);
            var extStart = filepath.lastIndexOf(".");
            var ext = filepath.substring(extStart, filepath.length).toUpperCase();
            /*
             作者：z@qq.com
                时间：2016-12-10
                描述：鉴定每个图片上传尾椎限制
            * */
            if(ext != ".BMP" && ext != ".PNG" && ext != ".GIF" && ext != ".JPG" && ext != ".JPEG") {
              $(".shade").fadeIn(500);
              $(".text_span").text("图片限于bmp,png,gif,jpeg,jpg格式");
              this.value = "";
              $(".img_div").html("");
              return false;
            } else {
              /*
               若规则全部通过则在此提交url到后台数据库
               * */
              img_html = "<div class='isImg'><img src='" + objUrl + "' onclick='javascript:lookBigImg(this)' style='height: 100%; width: 100%;' /><button class='removeBtn' onclick='javascript:removeImg(this)'>x</button></div>";
              img_div.append(img_html);
            }
          }
          /*
           作者：z@qq.com
              时间：2016-12-10
              描述：鉴定每个图片大小总和
          * */
          var file_size = 0;
          var all_size = 0;
          for(j = 0; j < this.files.length; j++) {
            file_size = this.files[j].size;
            all_size = all_size + this.files[j].size;
            var size = all_size / 1024;
            if(size > 500) {
              $(".shade").fadeIn(500);
              $(".text_span").text("上传的图片大小不能超过100k！");
              this.value = "";
              $(".img_div").html("");
              return false;
            }
          }
          /*
           作者：z@qq.com
              时间：2016-12-10
              描述：鉴定每个图片宽高 以后会做优化 多个图片的宽高 暂时隐藏掉 想看效果可以取消注释就行
          * */
          //          var img = new Image();
          //          img.src = objUrl;
          //          img.onload = function() {
          //            if (img.width > 100 && img.height > 100) {
          //              alert("图片宽高不能大于一百");
          //              $("#myFile").val("");
          //              $(".img_div").html("");
          //              return false;
          //            }
          //          }
          return true;
        });
        /*
         作者：z@qq.com
            时间：2016-12-10
            描述：鉴定每个浏览器上传图片url 目前没有合并到Ie
         * */
        function getObjectURL(file) {
          var url = null;
          if(window.createObjectURL != undefined) { // basic
            url = window.createObjectURL(file);
          } else if(window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
          } else if(window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
          }
          //console.log(url);
          return url;
        }
      });
      /*
       作者：z@qq.com
           时间：2016-12-10
            描述：上传图片附带删除 再次地方可以加上一个ajax进行提交到后台进行删除
       * */
      function removeImg(r){
        $(r).parent().remove();
      }
      /*
       作者：z@qq.com
           时间：2016-12-10
            描述：上传图片附带放大查看处理
       * */
      function lookBigImg(b){
        $(".shadeImg").fadeIn(500);
        $(".showImg").attr("src",$(b).attr("src"))
      }
      /*
       作者：z@qq.com
           时间：2016-12-10
            描述：关闭弹出层
       * */
      function closeShade(){
        $(".shade").fadeOut(500);
      }
      /*
       作者：z@qq.com
           时间：2016-12-10
            描述：关闭弹出层
       * */
      function closeShadeImg(){
        $(".shadeImg").fadeOut(500);
      }