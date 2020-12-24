// lazyload config
var JSLibraryPath = '/assets/admin/js/'; // for server
//var JSLibraryPath = '/duroosapp/public//assets/admin/js/'; // for local
var MODULE_CONFIG = {
    easyPieChart:   [ JSLibraryPath+'jquery/jquery.easy-pie-chart/dist/jquery.easypiechart.fill.js' ],
    sparkline:      [ JSLibraryPath+'jquery/jquery.sparkline/dist/jquery.sparkline.retina.js' ],
    plot:           [ JSLibraryPath+'jquery/flot/jquery.flot.js',
                        JSLibraryPath+'jquery/flot/jquery.flot.resize.js',
                        JSLibraryPath+'jquery/flot/jquery.flot.pie.js',
                        JSLibraryPath+'jquery/flot.tooltip/js/jquery.flot.tooltip.min.js',
                        JSLibraryPath+'jquery/flot-spline/js/jquery.flot.spline.min.js',
                        JSLibraryPath+'jquery/flot.orderbars/js/jquery.flot.orderBars.js'],
    vectorMap:      [ JSLibraryPath+'jquery/bower-jvectormap/jquery-jvectormap-1.2.2.min.js',
                        JSLibraryPath+'jquery/bower-jvectormap/jquery-jvectormap.css',
                        JSLibraryPath+'jquery/bower-jvectormap/jquery-jvectormap-world-mill-en.js',
                        JSLibraryPath+'jquery/bower-jvectormap/jquery-jvectormap-us-aea-en.js' ],
    dataTable:      [
                        JSLibraryPath+'jquery/datatables/media/js/jquery.dataTables.min.js',
                        JSLibraryPath+'jquery/plugins/integration/bootstrap/3/dataTables.bootstrap.js',
                        JSLibraryPath+'jquery/plugins/integration/bootstrap/3/dataTables.bootstrap.css'],
    footable:       [
                        JSLibraryPath+'jquery/footable/dist/footable.all.min.js',
                        JSLibraryPath+'jquery/footable/css/footable.core.css'
                    ],
    screenfull:     [
                        JSLibraryPath+'jquery/screenfull/dist/screenfull.min.js'
                    ],
    sortable:       [
                        JSLibraryPath+'jquery/html.sortable/dist/html.sortable.min.js'
                    ],
    nestable:       [
                        JSLibraryPath+'jquery/nestable/jquery.nestable.css',
                        JSLibraryPath+'jquery/nestable/jquery.nestable.js'
                    ],
    summernote:     [
                        JSLibraryPath+'jquery/summernote/dist/summernote.css',
                        JSLibraryPath+'jquery/summernote/dist/summernote.js',
                        JSLibraryPath+'jquery/summernote/dist/lang/summernote-ar-AR.js'
                    ],
    parsley:        [
                        JSLibraryPath+'jquery/parsleyjs/dist/parsley.css',
                        JSLibraryPath+'jquery/parsleyjs/dist/parsley.min.js'
                    ],
    select2:        [
                        JSLibraryPath+'jquery/select2/dist/css/select2.min.css',
                        JSLibraryPath+'jquery/select2-bootstrap-theme/dist/select2-bootstrap.min.css',
                        JSLibraryPath+'jquery/select2-bootstrap-theme/dist/select2-bootstrap.4.css',
                        JSLibraryPath+'jquery/select2/dist/js/select2.min.js'
                    ],
    datetimepicker: [
                        JSLibraryPath+'jquery/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css',
                        JSLibraryPath+'jquery/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.dark.css',
                        JSLibraryPath+'moment/moment.js',
                        JSLibraryPath+'jquery/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
                    ],
    chart:          [
                        JSLibraryPath+'echarts/build/dist/echarts-all.js',
                        JSLibraryPath+'echarts/build/dist/theme.js',
                        JSLibraryPath+'echarts/build/dist/jquery.echarts.js'
                    ],
    bootstrapWizard:[
                        JSLibraryPath+'twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js'
                    ],
    fullCalendar:   [
                        JSLibraryPath+'moment/moment.js',
                        JSLibraryPath+'fullcalendar/dist/fullcalendar.min.js',
                        JSLibraryPath+'fullcalendar/dist/fullcalendar.css',
                        JSLibraryPath+'fullcalendar/dist/fullcalendar.theme.css',
                        JSLibraryPath+'scripts/plugins/calendar.js'
                    ],
    dropzone:       [
                        JSLibraryPath+'dropzone/dist/min/dropzone.min.js',
                        JSLibraryPath+'dropzone/dist/min/dropzone.min.css'
                    ]
  };
