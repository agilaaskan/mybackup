<script>
    function loadjscssfile(filename, filetype){
       if (filetype=="js"){ //if filename is a external JavaScript file
           var fileref=document.createElement('script')
           fileref.setAttribute("type","text/javascript")
           fileref.setAttribute("src", filename)
       }
       else if (filetype=="css"){ //if filename is an external CSS file
           var fileref=document.createElement("link")
           fileref.setAttribute("rel", "stylesheet")
           fileref.setAttribute("type", "text/css")
           fileref.setAttribute("href", filename)
       }
       if (typeof fileref!="undefined") { 
           document.getElementsByTagName("footer")[0].appendChild(fileref)
         }
   }
  
       loadjscssfile("https://sandboxm4-4w2ikjy-jnn4ff2eo42oa.us-3.magentosite.cloud/static/frontend/Magento/luma_child_theme/es_MX/css/styles-m.css", "css")
       loadjscssfile("https://sandboxm4-4w2ikjy-jnn4ff2eo42oa.us-3.magentosite.cloud/static/frontend/Magento/luma_child_theme/es_MX/css/print.css", "css")
       loadjscssfile("https://sandboxm4-4w2ikjy-jnn4ff2eo42oa.us-3.magentosite.cloud/static/frontend/Magento/luma_child_theme/es_MX/css/styles-l.css", "css")
loadjscssfile("https://sandboxm4-4w2ikjy-jnn4ff2eo42oa.us-3.magentosite.cloud/static/frontend/Magento/luma_child_theme/es_MX/css/custom.css", "css")
       loadjscssfile("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css")
       loadjscssfile("https://sandboxm4-4w2ikjy-jnn4ff2eo42oa.us-3.magentosite.cloud/static/frontend/Magento/luma_child_theme/es_MX/mage/polyfill.js", "js")
loadjscssfile("https://cdn.searchspring.net/search/v3/js/searchspring.catalog.js?70bbfe", "js")
      
</script>