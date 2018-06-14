<!--
 * @email : sfandrianah2@gmail.com
 * @author : Syahrial Fandrianah
 * @Description : ETOLL - Dashboard by Telkom Sigma 2017
-->
<!DOCTYPE html>
<html lang="en">
    @include('guest.dashboard.template.head')
    <style>
        .datepicker {
            display:block;
            z-index: 1000000 !important;
        }
        .dropdown-menu{
            display:block;
            opacity:100;
            visibility: visible;
        }
        .background-loading{
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 1000001;
            background: url('http://i.imgur.com/6XC1xAo.gif') center no-repeat rgba(255, 255, 255, 0.75);
        }

    </style>
    <body>

        <div class="wrapper">
            <div class="main-panel">
                <nav class="navbar navbar-default navbar-fixed" style="height:65px;">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!--<a class="navbar-brand" href="#">-->
                            <a class="" href="#">
                                <img src="<?= URL('../../etoll-customer/public/img/etc-1.png'); ?>" height="50"/>
                            </a>
                            <a class="" href="#" >
                                <img style="height:40px;" src="{!! asset('img/logo-telkom-1.png') !!}" height="50"/>
                            </a>

                            <!--<a class="navbar-brand" href="#">ETOLL - Dashboard by Telkom Sigma 2017</a>-->
                        </div>
                        <div class="collapse navbar-collapse">

                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                    <!--                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="fa fa-dashboard"></i>
                                                                            ETOLL - Dashboard by Telkomsigma 2017
                                                                        </a>-->

                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="">
                                        <!--Account-->
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>


                <div class="content">
                    <div class="container-fluid">
                        <?php
//                        $new = new Collective\Html\FormBuilder;
                        echo Form::token();
                        ?>
                        @yield('content')

                    </div>
                </div>


                <footer class="footer">
                    <div class="container-fluid">
                        <nav class="pull-left">
                            <ul>
                                <li>
                                    <a href="#">

                                    </a>
                                </li>

                            </ul>
                        </nav>
                        <p class="copyright pull-right">
                            &copy; <script>document.write(new Date().getFullYear())</script> 
                            <a href="#">ETC Jasa Marga</a>, All Right Reserved
                        </p>
                    </div>
                </footer>
            </div>
        </div>

        <!-- <script>
            function exportToPDFById(e, id) {
                var dt = new Date();
                var day = dt.getDate();
                var month = dt.getMonth() + 1;
                var year = dt.getFullYear();
                var hour = dt.getHours();
                var mins = dt.getMinutes();
                var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
//                var content = $('#' + id).html();
                $(e).attr("href", "<?= URL('/page/export/pdf?q='); ?>" + encodeURIComponent($('#' + id).html()))
                        .attr("download", id + '-' + postfix + '.pdf')
                ;
//                window.open('<?= URL('/page/export/pdf?q='); ?>'+encodeURIComponent(content), '_blank');
//                window.open("GET", '<?= URL('/page/export/pdf?q='); ?>'+encodeURIComponent(content), true);
//                window.send(null);
            }

            function exportToPDFById2(id) {
                $('#myModal_self').attr("style", "z-index:100500;");
                $('#myModal_self').modal({backdrop: 'static', keyboard: false});
//    $('body').addClass("page-sidebar-closed");
//                $('#' + id).attr("style", "left:-10%;top:2%;width:1550px;position:fixed;");
                $('#modal-title-self').html(id);
                $('#modal-body-self').html('<div class="row" style=""><iframe style="right:0; height:800px;top:0; bottom:0;width:100%;" id="frameReport" ></iframe><div>');
//                var pdf = new jsPDF('p', 'pt', 'letter');
                var pdf = new jsPDF('p', 'mm', [297, 210]);
                var canvas = pdf.canvas;
                canvas.height = 10 * 11;
                canvas.width = 10 * 8.5;

                // can also be document.body
                var html = $('#' + id)[0];

                html2pdf(html, pdf, function (pdf) {
//        pdf.output('dataurlnewwindow');
                    $('#frameReport').attr("src", pdf.output('datauristring'));
//        $('body').removeClass("page-sidebar-closed");
                    $('#' + id).removeAttr('style');
//        $('.page-sidebar-menu').show();
                });

            }

            function printElemCustomerHistory(elem, title,startdate,enddate)
            {
                var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                strCSS = '<style>body,h1,h2,h3,h4,h5,h6{font-family:"Open Sans",sans-serif}table,td,th{border:1px solid #ddd;text-align:left}table{border-collapse:collapse;width:100%}th,td{padding:15px}th{background:#eee}</style>';
                mywindow.document.write('<html><head><title>' + title + '</title>');
                mywindow.document.write(strCSS);
                mywindow.document.write('</head><body>');
                if(typeof header == 'undefined'){
                    
                }
                var header = '<div class="row" style="margin-bottom: 20px;">';
                header += '<div class="col-md-12">';
                header += '<div style="text-align: center;font-size: 18px;">Report&nbsp;History&nbsp;Transaction</div>';
                header += '<div style="text-align: center;font-size: 14px;">From&nbsp; '+startdate+'&nbsp;To&nbsp; '+enddate+'</div>';
                header += '</div>';
                header += '</div>';
//                header += '';
//                header += '';
                mywindow.document.write(header);
                mywindow.document.write(document.getElementById(elem).innerHTML);
                mywindow.document.write('</body></html>');

                mywindow.document.close(); 
                mywindow.focus(); 

                mywindow.print();
                mywindow.close();

                return true;
            }
        </script> -->
        {!! HTML::script('js/partial/customer-dashboard-custom.js') !!}
        {!! HTML::script('js/jsPDF-1.3.2/dist/jspdf.debug.js') !!}
        {!! HTML::script('js/jsPDF-1.3.2/libs/html2pdf.js?v1.1') !!}
    </body>
    @include('guest.dashboard.template.footer')
</html>
