require(['mage/url', 'jquery','domReady!' ,'jquery/ui'],function($) {

	$(document).ready(function() {
                var cod_url = url.build('Shipping/index/cashondelivery');
                console.log("Cash on delivery controller calling: "+ cod_url);
                var a = 0;
                $.ajax({
                    url: cod_url,
                    type: 'GET',
                    dataType: 'json',
                    
                    complete: function(response) {                        
                    console.log('completed');
                    console.log(response);

                    },

                    error: function (xhr, status, errorThrown) {
                        console.log('Sorry ');
                    }
                });

            }); 

});