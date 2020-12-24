@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Welcome {{Auth::user()->name}}</h4>
                    <small class="text-muted">Education+ Administration Dashboard</small>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="padding">
            {{--receivables and payables--}}
            <div class="row">
                {{--receivables--}}
                <div class="col-xs-6 col-sm-6">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-40 primary text-center rounded">
                              <i class="material-icons">shopping_basket</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-md"><a href="">{{$todaySaleCollection['saleCount']}} <span class="text-sm">Sales</span></a></h4>
                            <small class="text-muted">{{$todaySaleCollection['sale']}} SR - Received</small>
                            <br>
                            <small class="text-muted">&nbsp</small>
                        </div>
                    </div>
                </div>

                {{--payables--}}
                <div class="col-xs-6 col-sm-6">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-40 primary text-center rounded">
                              <i class="material-icons">payment</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-md"><a href="">{{$todayPaymentCollection['paymentCount']}} <span class="text-sm">Payments</span></a></h4>
                            <small class="text-muted">{{$todayPaymentCollection['payable']}} SR - Payable</small>
                            <br>
                            <small class="text-muted">{{$todayPaymentCollection['paid']}} SR - Paid</small>
                        </div>
                    </div>
                </div>
            </div>

            {{--receivable and payable charts--}}
            <div class="row">
                {{--receivables--}}
{{--                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Sales</h3>
                            <small class="block text-muted">Calculated in last 7 days</small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options=" {
              tooltip : {
                  trigger: 'axis'
              },
              calculable : true,
              yAxis : [
                  {
                      type : 'category',
                      //data : ['SUN','MON','TUE','WED','THU','FRI','SAT','SUN']
                      data : [{{implode(',',$weekDaysCollection->toArray())}}]
                  }
              ],
              xAxis : [
                  {
                      type : 'value'
                  }
              ],
              series : [
                  {
                      name:'Sale',
                      type:'bar',
                      data:[{{implode(',',$weeklySalesCollection->toArray())}}],
                      markPoint : {
                          data : [
                              {type : 'max', name: 'Max'},
                              {type : 'min', name: 'Min'}
                          ]
                      },
                      markLine : {
                          data : [
                              {type : 'average', name: 'Average'}
                          ]
                      }
                  },
              ]
            }" style="height:300px" >
                            </div>
                        </div>
                    </div>
                </div>--}}
                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Sales</h3>
                            <small class="block text-muted">Calculated in last 7 days</small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options="{
                                                        tooltip : {
                                                            trigger: 'axis'
                                                        },
                                                        legend: {
                                                            //data:['Sale']
                                                            data:['']
                                                        },
                                                        calculable : true,
                                                        xAxis : [
                                                            {
                                                                type : 'category',
                                                                boundaryGap : true,
                                                                //data : ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']
                                                                data : [{{implode(',',$weekDaysCollection->toArray())}}]
                                                            }
                                                        ],
                                                        yAxis : [
                                                            {
                                                                type : 'value'
                                                            }
                                                        ],
                                                        series : [
                                                            {
                                                                name:'Sale',
                                                                type:'line',
                                                                smooth:true,
                                                                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                                                data:[{{implode(',',$weeklySalesCollection->toArray())}}]
                                                            },
                                                        ]

                                                    }" style="height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>

                {{--payables--}}
{{--                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Payments</h3>
                            <small class="block text-muted">Calculated in last 7 days</small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options=" {
              tooltip : {
                  trigger: 'axis'
              },
              calculable : true,
              yAxis : [
                  {
                      type : 'category',
                      //data : ['SUN','MON','TUE','WED','THU','FRI','SAT','SUN']
                      data : [{{implode(',',$weekDaysCollection->toArray())}}]
                  }
              ],
              xAxis : [
                  {
                      type : 'value'
                  }
              ],
              series : [
                  {
                      name:'Payment',
                      type:'bar',
                      data:[{{implode(',',$weeklyPaymentCollection->toArray())}}],
                      markPoint : {
                          data : [
                              {type : 'max', name: 'Max'},
                              {type : 'min', name: 'Min'}
                          ]
                      },
                      markLine : {
                          data : [
                              {type : 'average', name: 'Average'}
                          ]
                      }
                  },
              ]
            }" style="height:300px" >
                            </div>
                        </div>
                    </div>
                </div>--}}
                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Payments</h3>
                            <small class="block text-muted">Calculated in last 7 days</small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options="{
                                                        tooltip : {
                                                            trigger: 'axis'
                                                        },
                                                        legend: {
                                                            //data:['Sale']
                                                            data:['']
                                                        },
                                                        calculable : true,
                                                        xAxis : [
                                                            {
                                                                type : 'category',
                                                                boundaryGap : true,
                                                                //data : ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']
                                                                data : [{{implode(',',$weekDaysCollection->toArray())}}]
                                                            }
                                                        ],
                                                        yAxis : [
                                                            {
                                                                type : 'value'
                                                            }
                                                        ],
                                                        series : [
                                                            {
                                                                name:'Sale',
                                                                type:'line',
                                                                smooth:true,
                                                                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                                                data:[{{implode(',',$weeklyPaymentCollection->toArray())}}]
                                                            },
                                                        ]

                                                    }" style="height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--student , tutors--}}
            <div class="row">
                {{--students--}}
                <div class="col-xs-12 col-sm-6">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            {{--<span class="w-48 rounded  accent">--}}
                            <span class="w-48 rounded  primary">
                              <i class="material-icons">person_outline</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-lg _300"><a href="{{route('admin.students')}}">{{$total_students}} <span class="text-sm">Students</span></a></h4>
                            <small class="text-muted">{{$new_students}} new.</small>
                        </div>
                    </div>
                </div>

                {{--tutors--}}
                <div class="col-xs-6 col-sm-6">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            {{--<span class="w-48 rounded primary">--}}
                            <span class="w-48 rounded accent">
                              <i class="material-icons">person</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-lg _300"><a href="{{route('admin.tutors')}}">{{$total_tutors}} <span class="text-sm">Tutors</span></a></h4>
                            <small class="text-muted">{{$new_tutors}} new.</small>
                        </div>
                    </div>
                </div>

                {{--sessions--}}
                <!--div class="col-xs-6 col-sm-4">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                    <span class="w-48 rounded warn">
                      <i class="material-icons">question_answer</i>
                      <i class="material-icons">voice_chat</i>
                    </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-lg _300"><a href="{{--{{route('admin.sessions')}}--}}">{{$total_learning_sessions}} <span class="text-sm">Sessions</span></a></h4>
                            <small class="text-muted">{{$active_learning_session}} running.</small>
                        </div>
                    </div>
                </div-->
            </div>

            {{--charts--}}
            <div class="row">
                {{--students / tutors--}}
                <!--div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Total Students And Tutors Joined - Year {{date('Y')}}</h3>
                            <small class="block text-muted">Total Students Overall: <strong>{{$total_students}}</strong></small>
                            <small class="block text-muted">Total Tutors Overall: <strong>{{$total_tutors}}</strong></small>
                        </div>
                        <div class="box-body">
                        <div ui-jp="chart" ui-options=" {
                                  tooltip : {
                                      trigger: 'axis'
                                  },
                                  legend: {
                                      data:['Students','Tutors']
                                  },
                                  calculable : true,
                                  xAxis : [
                                      {
                                          type : 'category',
                                          data : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
                                      }
                                  ],
                                  yAxis : [
                                      {
                                          type : 'value'
                                      }
                                  ],
                                  series : [
                                      {
                                          name:'Students',
                                          type:'bar',
                                          data:[{{implode(',',$yearlyStudentJoinedCollection->toArray())}}],
                                          //data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                                          markPoint : {
                                              data : [
                                                  {type : 'max', name: 'Max'},
                                                  {type : 'min', name: 'Min'}
                                              ]
                                          },
                                          markLine : {
                                              data : [
                                                  {type : 'average', name: 'Average'}
                                              ]
                                          }
                                      },
                                      {
                                          name:'Tutors',
                                          type:'bar',
                                          data:[{{implode(',',$yearlyTutorJoinedCollection->toArray())}}],
                                          //data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                                          markPoint : {
                                              data : [
                                                  {type : 'max', name: 'Max'},
                                                  {type : 'min', name: 'Min'}
                                              ]
                                          },
                                          markLine : {
                                              data : [
                                                  {type : 'average', name: 'Average'}
                                              ]
                                          }
                                      }
                                  ]
                                }" style="height:300px" >
                            </div>
                        </div>
                    </div>
                </div-->

                {{--Students--}}
                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Total Students Joined - Year {{date('Y')}}</h3>
                            <small class="block text-muted">Total Students Overall: <strong>{{$total_students}}</strong></small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options=" {
                  tooltip : {
                      trigger: 'axis'
                  },
                  legend: {
                      data:['Students']
                  },
                  calculable : true,
                  xAxis : [
                      {
                          type : 'category',
                          data : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
                      }
                  ],
                  yAxis : [
                      {
                          type : 'value'
                      }
                  ],
                  series : [
                      {
                          name:'Students',
                          type:'bar',
                          data:[{{implode(',',$yearlyStudentJoinedCollection->toArray())}}],
                          //data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                          /*markPoint : {
                              data : [
                                  {type : 'max', name: 'Max'},
                                  {type : 'min', name: 'Min'}
                              ]
                          },*/
                          markLine : {
                              data : [
                                  {type : 'average', name: 'Average'}
                              ]
                          }
                      }
                  ]
                }" style="height:300px" >
                            </div>
                        </div>
                    </div>
                </div>

                {{--Tutors--}}
                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Total Tutors Joined - Year {{date('Y')}}</h3>
                            <small class="block text-muted">Total Tutors Overall: <strong>{{$total_tutors}}</strong></small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options=" {
                  tooltip : {
                      trigger: 'axis'
                  },
                  legend: {
                      data:['Tutors']
                  },
                  calculable : true,
                  xAxis : [
                      {
                          type : 'category',
                          data : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
                      }
                  ],
                  yAxis : [
                      {
                          type : 'value'
                      }
                  ],
                  series : [
                      {
                          name:'Tutors',
                          type:'bar',
                          data:[{{implode(',',$yearlyTutorJoinedCollection->toArray())}}],
                          //data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                          /*markPoint : {
                              data : [
                                  {type : 'max', name: 'Max'},
                                  {type : 'min', name: 'Min'}
                              ]
                          },*/
                          markLine : {
                              data : [
                                  {type : 'average', name: 'Average'}
                              ]
                          }
                      }
                  ]
                }" style="height:300px" >
                            </div>
                        </div>
                    </div>
                </div>

                {{--session--}}
                <!--div class="col-sm-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>Total Sessions - Year {{date('Y')}}</h3>
                            <small class="block text-muted">Total Sessions Overall: <strong>{{$total_learning_sessions}}</strong></small>
                            <small class="block text-muted"> <strong> <br></strong></small>
                        </div>
                        <div class="box-body">
                            <div ui-jp="chart" ui-options=" {
                  tooltip : {
                      trigger: 'axis'
                  },
                  legend: {
                      data:['Sessions']
                  },
                  calculable : true,
                  xAxis : [
                      {
                          type : 'category',
                          data : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
                      }
                  ],
                  yAxis : [
                      {
                          type : 'value'
                      }
                  ],
                  series : [
                      {
                          name:'Sessions',
                          type:'bar',
                          data:[{{implode(',',$yearlySessionOccurredCollection->toArray())}}],
                          //data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                          /*markPoint : {
                              data : [
                                  {type : 'max', name: 'Max'},
                                  {type : 'min', name: 'Min'}
                              ]
                          },*/
                          markLine : {
                              data : [
                                  {type : 'average', name: 'Average'}
                              ]
                          }
                      }
                  ]
                }" style="height:300px" >
                            </div>
                        </div>
                    </div>
                </div-->

            </div>

            {{--Online Status and Topics--}}
            <div class="row">
                {{--Student--}}
                <div class="col-sm-6 col-md-4">
                    <div class="box" style="height: 350px; max-height: 340px;">
                        <div class="box-header">
                            <a href="{{route('admin.students')}}"><h3>Students</h3></a>
                        </div>
                        <ul class="list no-border p-b">
                            @foreach($studentsCollection as $student)
                                <li class="list-item">
                                    <a href="{{route('admin.student.show',['id'=>$student->id])}}" class="list-left">
                                        <span class="w-40 avatar">
                                          {{-- <img src="{{asset($student->profile->picture)}}" alt="..."> --}}
                                          <i class="{{($student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-stu-'.$student->email}}"></i>
                                        </span>
                                    </a>
                                    <div class="list-body">
                                        <div><a href="{{route('admin.student.show',['id'=>$student->id])}}">{{$student->name}} {{$student->last_name}}</a></div>
                                        <small class="text-muted text-ellipsis">
                                            {{--@foreach($student->profile->student_specializations as $student_specialization)--}}
                                                {{--{{$student_specialization->topic->topic}}@if(!$loop->last),@endif--}}
                                            {{--@endforeach--}}
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{--Tutor--}}
                <div class="col-sm-6 col-md-4">
                    <div class="box" style="height: 350px; max-height: 340px;">
                        <div class="box-header">
                            <a href="{{route('admin.tutors')}}"><h3>Tutors</h3></a>
                        </div>
                        <ul class="list no-border p-b">
                            @foreach($tutorsCollection as $tutor)
                                <li class="list-item">
                                    <a href="{{route('admin.tutor.show',['id' => $tutor->id])}}" class="list-left">
                                        <span class="w-40 avatar">
                                          <img src="{{asset($tutor->profile->picture)}}" alt="...">
                                          <i class="{{($tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-tut-'.$tutor->email}}"></i>
                                        </span>
                                    </a>
                                    <div class="list-body">
                                        <div><a href="{{route('admin.tutor.show',['id' => $tutor->id])}}">{{$tutor->name}} {{$tutor->last_name}}</a></div>
                                        <small class="text-muted text-ellipsis">
                                            @foreach($tutor->profile->tutor_specializations as $tutor_specialization)
                                                {{$tutor_specialization->topic->topic}}@if(!$loop->last),@endif
                                            @endforeach
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{--Topics--}}
                <div class="col-sm-6 col-md-4">
                    <div class="box" style="height: 350px; max-height: 340px;">
                        <div class="box-header">
                            <a href="{{route('admin.topics')}}"><h3>Topics</h3></a>
                        </div>
                        <ul class="list no-border p-b">
                            @foreach($topicsCollection as $topic)
                                <li class="list-item">
                                    <a href="{{route('admin.topic.show',['id'=>$topic->id])}}" class="list-left">
                                        <span class="w-40 avatar success">
                                          <span>{{$topic->topic[0]}}</span> {{--First alphabate of topic--}}
                                        </span>
                                    </a>
                                    <div class="list-body">
                                        <div><a href="{{route('admin.topic.show',['id'=>$topic->id])}}">{{$topic->topic}}</a></div>
                                        <small class="text-muted text-ellipsis">Sub topics</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->
    </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        // tutor
        var channel = pusher.subscribe('tutor.status');
        channel.bind('tutor.status.event', function (data) {
            var tutor = data.tutor;
            // console.log(tutor);
            var elements = document.getElementsByClassName('online-tut-'+tutor.email);
            $.each(elements, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.classList.remove('off');
                    element.classList.add('on');
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.classList.remove('on');
                        element.classList.add('off');
                    }
                }
            });
        });

        // student
        var channel = pusher.subscribe('student.status');
        channel.bind('student.status.event', function (data) {
            var student = data.student;
            // console.log(student);
            var elements = document.getElementsByClassName('online-stu-'+student.email);
            $.each(elements, function (i, element) {
                if(student.online_status){
                    console.log("true");
                    element.classList.remove('off');
                    element.classList.add('on');
                }else {
                    if(!student.online_status){
                        console.log("false");
                        element.classList.remove('on');
                        element.classList.add('off');
                    }
                }
            });
        });
    </script>
@endsection