<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            #gmap{ width:700px; height: 500px; }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            

            <div class="content">
            <div id="gmap"></div>
        
        <!--our form-->
        <h2>Chosen Location</h2>
        <form action="#" method="get">
            <input type="text" id="lat" readonly="yes"><br>
            <input type="text" id="long" readonly="yes">
        </form>
        <button id="find">Find</button>

                
            </div>
        </div>

        
        <script type="text/javascript" src="{{asset('js/maps.js')}}"></script>
        <script type="text/javascript">
        var url ='{{url("/find-places")}}'; 
        $('#find').click(function(){ 
            var lat = $('#lat').val();
            var lng = $('#long').val();
            $.ajax({"url":url,
                "data":{"latitude":lat,"longitude":lng},
                "method":"GET",
                success:function(data){
                    if(data.success == 1){
                        data = data.data;
                        for(var i in data){
                            myLatLng = data[i].geometry.location;
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                title: data[i].name
                            });
                        }
                    }

                },
                error:function(xhr,status,response){

                }
            });


        });
        </script>
    </body>
</html>
