@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
            <div class="p-a white lt box-shadow">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="m-b-0 _300">Manage Reports</h4>
                    </div>
                    <div class="col-sm-6 text-sm-right"></div>
                </div>
            </div>
            <div class="row">@include('admin.layout.errors')</div>
            <div class="padding">
                <div class="box padding">
                    <div class="box-header"></div>
                    <div class="b-b b-primary nav-active-primary">
                        <ul class="nav nav-tabs">
                            {{--Sales--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'salesReport') active @endif" href="#salesTab" data-toggle="tab" data-target="#salesTab" aria-expanded="false">Sales Report</a>
                            </li>

                            {{--Tutor Balances--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'tutorBalances') active @endif" href="#tutBlncsTab" data-toggle="tab" data-target="#tutBlncsTab" aria-expanded="true">Tutor Balance Report</a>
                            </li>

                            {{--Student Balances--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'studentBalances') active @endif" href="#stdBlncsTab" data-toggle="tab" data-target="#stdBlncsTab" aria-expanded="true">Student Balance Report</a>
                            </li>

                            {{--Comprehensive report--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'comprehensiveReport') active @endif"
                                   href="#comprehensiveReportTab" data-toggle="tab" data-target="#comprehensiveReportTab" aria-expanded="true">Comprehensive report</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content p-a m-b-md">
                        {{--sales tab--}}
                        <div class="tab-pane @if($selectedTab == 'salesReport') active @endif" id="salesTab" aria-expanded="false">

                            {{--criteria & search--}}
                            <div class="">
                                <div class="row p-a">
                                    <div class="col-sm-5">
                                        <form method="GET" action="{{route('admin.reports')}}">
                                            <select class="input-sm form-control w-sm inline v-middle" name = "criteria">
                                                <option value="daily" @if($selectedCriteria == 'daily') selected @endif>Daily</option>
                                                <option value="weekly" @if($selectedCriteria == 'weekly') selected @endif>Weekly</option>
                                                <option value="monthly" @if($selectedCriteria == 'monthly') selected @endif>Monthly</option>
                                                <option value="quarterly" @if($selectedCriteria == 'quarterly') selected @endif>Quarterly</option>
                                                <option value="yearly"@if($selectedCriteria == 'yearly') selected @endif>Yearly</option>
                                                <option value="on_date"@if($selectedCriteria == 'on_date') selected @endif>On Date</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm white">Apply</button>
                                        </form>
                                    </div>

                                    <div class="col-sm-4"> </div>
                                    <div class="col-sm-3">
                                        @if($selectedCriteria == 'on_date')
                                            <form method="GET" action="{{route('admin.reports')}}">
                                                <input type="hidden" name="criteria" value="on_date">
                                                <div class="input-group input-group-sm">
                                                    <input type="date" class="form-control" placeholder="Search" value="@if(isset($searchTheDate)){{$searchTheDate}}@endif" name="searchTheDate">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn b-a white" type="button">Go!</button>
                                                    </span>
                                                </div>
                                            </form>
                                            @if(isset($searchTheDate) && !empty($searchTheDate))
                                                <strong>{{$salesDetailCollection->count()}}</strong> Result(s) found for: <strong>{{$searchTheDate}}</strong><br><a href="{{route('admin.reports',['criteria' => 'on_date'])}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                                            @else
                                                Total Records: {{$salesDetailCollection->total()}}
                                            @endif
                                        @else
                                            Total Records: {{$salesDetailCollection->total()}}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{--<chart>--}}
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Sales Report</h3>
                                                <small class="block text-muted">{{$salesDataCollection['msg']}}</small>
                                                <small class="block text-muted">Total sale: {{$salesDataCollection['totalAmount']}} SR</small>
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
                                                                data : [{{implode(',',$salesDataCollection['xAxisData']->toArray())}}]
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
                                                                data:[{{implode(',',$salesDataCollection['sales']->toArray())}}]
                                                            },
                                                        ]

                                                    }" style="height: 300px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{--</chart>--}}

                            {{--table--}}
                            <div class="table-responsive">
                                <table class="table table-striped b-t">
                                    <thead>
                                    <tr>
                                        <th style="width:20px;">
                                            Sno
                                        </th>
                                        <th></th> {{--profile image--}}
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th style="width:50px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $serialNumberCounter = ($salesDetailCollection->currentPage()-1) * $salesDetailCollection->perPage()+1;
                                    @endphp
                                    @foreach($salesDetailCollection as $salesDetail)
                                        @php
                                            $student = $salesDetail->student;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{$serialNumberCounter++ }}
                                            </td>
                                            <td>
                                                <span class="w-40 avatar">
                                                  <img src="{{asset($student->profile->picture)}}" alt="...">
                                                  <i class="{{($student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$student->email}}"></i>
                                                </span>
                                            </td>
                                            <td>{{$student->name}} {{$student->last_name}}</td>
                                            <td>{{$student->email}}</td>
                                            <td>{{$salesDetail->purchased_amount}} SR</td>
                                            <td>{{$salesDetail->created_at->format('F j, Y H:m:A')}}</td>
                                            <td style="width:18%;">
                                                <a class="btn btn-sm success" href="{{route('admin.student.show',['id'=>$student->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!--tr>
                                        <td>Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>0 SR</td>
                                        <td></td>
                                        <td style="width:18%;"></td>
                                    </tr-->
                                    </tbody>
                                </table>
                            </div>

                            <div class="dker p-a">
                                <div class="row">
                                    <div class="col-sm-4 hidden-xs"></div>
                                    <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($salesDetailCollection->currentpage()-1)*$salesDetailCollection->perpage()+1}} to {{(($salesDetailCollection->currentpage()-1)*$salesDetailCollection->perpage())+$salesDetailCollection->count()}} of {{ $salesDetailCollection->total() }} items</small> </div>
                                    <div class="col-sm-4 text-right text-center-xs ">
                                    {{ $salesDetailCollection->appends(request()->toArray())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--tutor balances tab--}}
                        <div class="tab-pane @if($selectedTab == 'tutorBalances') active @endif" id="tutBlncsTab" aria-expanded="false">
                            <div class="">
                                <div class="box">
                                    <div class="box-header"></div>

                                    {{--search--}}
                                    <div class="row p-a">
                                        <div class="col-sm-5">
                                            @if(request()->has('searchTheTutor'))
                                                <a href="{{route('admin.reports.export',['tab'=>'tutBlncRep','searchTheTutor' => request()->get('searchTheTutor')])}}" class="btn btn-success">Export</a>
                                                @if(request()->has('tut_page'))
                                                    <a href="{{route('admin.reports.export',['tab'=>'tutBlncRep','searchTheTutor' => request()->get('searchTheTutor'),'tut_page' => request()->get('tut_page')])}}" class="btn btn-success">Export</a>
                                                @endif
                                            @elseif(request()->has('tut_page'))
                                                <a href="{{route('admin.reports.export',['tab'=>'tutBlncRep','tut_page' => request()->get('tut_page')])}}" class="btn btn-success">Export</a>
                                            @else
                                                <a href="{{route('admin.reports.export',['tab'=>'tutBlncRep'])}}" class="btn btn-success">Export</a>
                                            @endif
                                        </div>
                                        <div class="col-sm-4"> </div>
                                        <div class="col-sm-3">
                                            <form method="GET" action="{{route('admin.reports')}}">
                                                <input type="hidden" name="tab" value="tutorBalances">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" placeholder="Search" value="@if(isset($searchTheTutor)){{$searchTheTutor}}@endif" name="searchTheTutor">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn b-a white" type="button">Go!</button>
                                                    </span>
                                                </div>
                                            </form>
                                            @if(isset($searchTheTutor) && !empty($searchTheTutor))
                                                <strong>{{$tutorsCollection->count()}}</strong> Result(s) found for: <strong>{{$searchTheTutor}}</strong><br><a href="{{route('admin.reports',['tab' => 'tutorBalances'])}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                                            @else
                                                Total Records: {{$tutorsCollection->total()}}
                                            @endif
                                        </div>
                                    </div>

                                    {{--table--}}
                                    @if($tutorsCollection->count() < 1)
                                        <div class="table-responsive text-center">No record found.</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped b-t">
                                                <thead>
                                                <tr>
                                                    <th style="width:20px;">
                                                        ID
                                                    </th>
                                                    <th></th> {{--profile image--}}
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Pending Amount</th>
                                                    <th>Withdraw Amount</th>
                                                    <th>Total Amount</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $serialNumberCounter = ($tutorsCollection->currentPage()-1) * $tutorsCollection->perPage()+1;
                                                @endphp
                                                @foreach($tutorsCollection as $tutor)
                                                    @php
                                                        $earning =  $tutor->sumOf_earning_transactions[0]->earning;
                                                        $withdraw = $tutor->someOf_withdraw_transactions[0]->withdraw;
                                                        $withdraw = ($withdraw) ? $withdraw : 0;
                                                        $pending = $earning - $withdraw;
                                                        $totalAmount = $earning + $withdraw;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{$serialNumberCounter++ }}
                                                        </td>
                                                        <td>
                                                            <span class="w-40 avatar">
                                                              <img src="{{asset($tutor->profile->picture)}}" alt="...">
                                                              <i class="{{($tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$tutor->email}}"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$tutor->name}}</td>
                                                        <td>{{$tutor->last_name}}</td>
                                                        <td>{{$tutor->email}}</td>
                                                        <td>{{$pending}}</td>
                                                        <td>{{$withdraw}}</td>
                                                        <td>{{$totalAmount}}</td>
                                                        <td style="width:18%;">
                                                            <a class="btn btn-sm success" href="{{route('admin.reports.tutor.show',['id' => $tutor->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="dker p-a">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"></div>
                                            <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($tutorsCollection->currentpage()-1)*$tutorsCollection->perpage()+1}} to {{(($tutorsCollection->currentpage()-1)*$tutorsCollection->perpage())+$tutorsCollection->count()}} of {{ $tutorsCollection->total() }} items</small> </div>
                                            <div class="col-sm-4 text-right text-center-xs ">
                                                {{ $tutorsCollection->appends(['tab' => 'tutorBalances'])->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--student balances tab--}}
                        <div class="tab-pane @if($selectedTab == 'studentBalances') active @endif" id="stdBlncsTab" aria-expanded="false">
                            <div class="">
                                <div class="box">
                                    <div class="box-header"></div>
                                    
                                    {{--search--}}
                                    <div class="row p-a">
                                        <div class="col-sm-5">
                                            @if(request()->has('searchTheStudent'))
                                                <a href="{{route('admin.reports.export',['tab'=>'stdBlncRep','searchTheStudent' => request()->get('searchTheStudent')])}}" class="btn btn-success">Export</a>
                                                @if(request()->has('std_page'))
                                                    <a href="{{route('admin.reports.export',['tab'=>'stdBlncRep','searchTheStudent' => request()->get('searchTheStudent'),'std_page' => request()->get('std_page')])}}" class="btn btn-success">Export</a>
                                                @endif
                                            @elseif(request()->has('std_page'))
                                                <a href="{{route('admin.reports.export',['tab'=>'stdBlncRep','std_page' => request()->get('std_page')])}}" class="btn btn-success">Export</a>
                                            @else
                                                <a href="{{route('admin.reports.export',['tab'=>'stdBlncRep'])}}" class="btn btn-success">Export</a>
                                            @endif
                                        </div>
                                        <div class="col-sm-4"> </div>
                                        <div class="col-sm-3">
                                            <form method="GET" action="{{route('admin.reports')}}">
                                                <input type="hidden" name="tab" value="studentBalances">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" placeholder="Search" value="@if(isset($searchTheStudent)){{$searchTheStudent}}@endif" name="searchTheStudent">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn b-a white" type="button">Go!</button>
                                                    </span>
                                                </div>
                                            </form>
                                            @if(isset($searchTheStudent) && !empty($searchTheStudent))
                                                <strong>{{$studentsCollection->count()}}</strong> Result(s) found for: <strong>{{$searchTheStudent}}</strong><br><a href="{{route('admin.reports',['tab' => 'studentBalances'])}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                                            @else
                                                Total Records: {{$studentsCollection->count()}}
                                            @endif
                                        </div>
                                    </div>

                                    {{--table--}}
                                    @if($studentsCollection->count() < 1)
                                        <div class="table-responsive text-center">No record found.</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped b-t">
                                                <thead>
                                                <tr>
                                                    <th style="width:20px;">
                                                        Sno
                                                    </th>
                                                    <th></th> {{--profile image--}}
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $serialNumberCounter = ($studentsCollection->currentPage()-1) * $studentsCollection->perPage()+1;
                                                @endphp
                                                @foreach($studentsCollection as $student)
                                                    @php
                                                        $totalPurchasedAmount = $student->totalPurchasedAmount[0]->totalPurchasedAmount;
                                                        $totalPurchasedAmount = ($totalPurchasedAmount) ? $totalPurchasedAmount : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{$serialNumberCounter++ }}
                                                        </td>
                                                        <td>
                                                            <span class="w-40 avatar">
                                                              <img src="{{asset($student->profile->picture)}}" alt="...">
                                                              <i class="{{($student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$student->email}}"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$student->name}}</td>
                                                        <td>{{$student->last_name}}</td>
                                                        <td>{{$student->email}}</td>
                                                        <td>{{$totalPurchasedAmount}}</td>
                                                        <td style="width:18%;">
                                                            <a class="btn btn-sm success" href="{{route('admin.reports.student.show',['id' => $student->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="dker p-a">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"></div>
                                            <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($studentsCollection->currentpage()-1)*$studentsCollection->perpage()+1}} to {{(($studentsCollection->currentpage()-1)*$studentsCollection->perpage())+$studentsCollection->count()}} of {{ $studentsCollection->total() }} items</small> </div>
                                            <div class="col-sm-4 text-right text-center-xs ">
                                                {{ $studentsCollection->appends(['tab' => 'studentBalances'])->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--comprehensive report tab--}}
                        <div class="tab-pane @if($selectedTab == 'comprehensiveReport') active @endif" id="comprehensiveReportTab" aria-expanded="false">
                            {{--Export & search--}}
                            <div class="">
                                <div class="row p-a">
                                    <div class="col-sm-2">
                                        {{--<a href="#" class="btn btn-success">Export</a>--}}

                                        @if(isset($searchCRFromDate) && empty($searchCRFromDate) && isset($searchCRToDate) && empty($searchCRToDate))
                                            <div class="text-info">
                                                <i>All Calculated record</i>
                                                {{--<u>{{date('Y-m-d', mktime(0,0,0,1,1,2018))}}</u> to <u>{{date('Y-m-d')}}</u>--}}
                                            </div>
                                        @endif
                                        Total Tutor Records: {{$comprehensiveTutorCollection->count()}}
                                        <br>
                                        Total Student Records: {{$comprehensiveStudentCollection->count()}}
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-8">
                                        <form method="GET" action="{{route('admin.reports')}}">
                                            <input type="hidden" name="tab" value="comprehensiveReport">
                                            <div class="input-group input-group-sm">
                                               <div class="row">
                                                   <div class="col-sm-1 form-label-group">From</div>
                                                   <div class="col-sm-4">
                                                       <input type="date" class="form-control" placeholder="From"
                                                              value="@if(isset($searchCRFromDate)){{$searchCRFromDate}}@endif" name="searchCRFromDate" required>
                                                   </div>

                                                   <div class="col-sm-1">To</div>
                                                   <div class="col-sm-4">
                                                       <input type="date" class="form-control" placeholder="To"
                                                              value="@if(isset($searchCRToDate)){{$searchCRToDate}}@endif" name="searchCRToDate" required>
                                                   </div>

                                                   <div class="col-sm-2">
                                                       <button type="submit" class="btn btn-outline-success" type="button">Go!</button>
                                                   </div>
                                               </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-sm-6"></div>
                                            <div class="col-sm-6">
                                                @if(isset($searchCRFromDate) && !empty($searchCRFromDate) && isset($searchCRToDate) && !empty($searchCRToDate))
                                                    <strong>{{$comprehensiveTutorCollection->count()+$comprehensiveStudentCollection->count()}}</strong>
                                                    Result(s) found for:
                                                    <strong>
                                                        <span class="text-muted">{{$searchCRFromDate}}</span> <u>to</u> <span class="text-muted">{{$searchCRToDate}}</span>
                                                    </strong>
                                                    <br>
                                                    <a href="{{route('admin.reports',['tab' => 'comprehensiveReport'])}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Tabs nav--}}
                            <div class="b-b b-primary nav-active-primary">
                                <ul class="nav nav-tabs">
                                    {{--Tutors--}}
                                    <li class="nav-item">
                                        <a class="nav-link @if($selectedCRTab == 'comprehensiveReportTutorTab') active @endif"
                                           href="#comprehensiveReportTutorTab" data-toggle="tab" data-target="#comprehensiveReportTutorTab" aria-expanded="false">Tutors</a>
                                    </li>

                                    {{--Students--}}
                                    <li class="nav-item">
                                        <a class="nav-link @if($selectedCRTab == 'comprehensiveReportStudentTab') active @endif"
                                           href="#comprehensiveReportStudentTab" data-toggle="tab" data-target="#comprehensiveReportStudentTab" aria-expanded="false">Students</a>
                                    </li>
                                </ul>
                            </div>

                            {{--Tabs--}}
                            <div class="tab-content p-a m-b-md">
                                {{--Tutors Tab--}}
                                <div class="tab-pane @if($selectedCRTab == 'comprehensiveReportTutorTab') active @endif" id="comprehensiveReportTutorTab" aria-expanded="false">
                                    @if($comprehensiveTutorCollection->count() < 1)
                                        <div class="table-responsive text-center">No record found.</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped b-t">
                                                <thead>
                                                <tr>
                                                    <th style="width:20px;">
                                                        Sno
                                                    </th>
                                                    <th></th> {{--profile picture--}}
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $serialNumberCounter = ($comprehensiveTutorCollection->currentPage()-1) * $comprehensiveTutorCollection->perPage()+1;
                                                @endphp
                                                @foreach($comprehensiveTutorCollection as $tutorBalance)
                                                    <tr>
                                                        <td>
                                                            {{$serialNumberCounter++ }}
                                                        </td>
                                                        <td>
                                                            <span class="w-40 avatar">
                                                              <img src="{{asset($tutorBalance->tutor->profile->picture)}}" alt="...">
                                                              <i class="{{($tutorBalance->tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$tutorBalance->tutor->email}}"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$tutorBalance->tutor->name}}</td>
                                                        <td>{{$tutorBalance->tutor->last_name}}</td>
                                                        <td>{{$tutorBalance->tutor->email}}</td>
                                                        <td>{{strtoupper($tutorBalance->type)}}</td>
                                                        <td>{{($tutorBalance->type == 'earning') ? $tutorBalance->earning_amount : $tutorBalance->withdraw_amount}}</td>
                                                        <td>{{($tutorBalance->created_at) ? $tutorBalance->created_at->format('F j, Y'): ''}}</td>
                                                        <td style="width:18%;">
                                                            <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="dker p-a">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"></div>
                                            <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($comprehensiveTutorCollection->currentpage()-1)*$comprehensiveTutorCollection->perpage()+1}} to {{(($comprehensiveTutorCollection->currentpage()-1)*$comprehensiveTutorCollection->perpage())+$comprehensiveTutorCollection->count()}} of {{ $comprehensiveTutorCollection->total() }} items</small> </div>
                                            <div class="col-sm-4 text-right text-center-xs ">
                                                @php
                                                    $crTutparams = request()->toArray();
                                                    $crTutparams['tab'] = 'comprehensiveReport';
                                                    $crTutparams['crTab'] = 'comprehensiveReportTutorTab';
                                                @endphp
                                                {{ $comprehensiveTutorCollection->appends($crTutparams)->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--Students Tab--}}
                                <div class="tab-pane @if($selectedCRTab == 'comprehensiveReportStudentTab') active @endif" id="comprehensiveReportStudentTab" aria-expanded="false">
                                    @if($comprehensiveStudentCollection->count() < 1)
                                        <div class="table-responsive text-center">No record found.</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped b-t">
                                                <thead>
                                                <tr>
                                                    <th style="width:20px;">
                                                        Sno
                                                    </th>
                                                    <th></th> {{--profile picture--}}
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Type</th>
                                                    <th>Minutes</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    {{--                                            <th style="width:50px;">Action</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $serialNumberCounter = ($comprehensiveStudentCollection->currentPage()-1) * $comprehensiveStudentCollection->perPage()+1;
                                                @endphp
                                                @foreach($comprehensiveStudentCollection as $studentBalance)
                                                    <tr>
                                                        <td>
                                                            {{$serialNumberCounter++ }}
                                                        </td>
                                                        <td>
                                                            <span class="w-40 avatar">
                                                              <img src="{{asset($studentBalance->student->profile->picture)}}" alt="...">
                                                              <i class="{{($studentBalance->student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$studentBalance->student->email}}"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$studentBalance->student->name}}</td>
                                                        <td>{{$studentBalance->student->last_name}}</td>
                                                        <td>{{$studentBalance->student->email}}</td>
                                                        <td>{{strtoupper($studentBalance->type)}}</td>
                                                        <td>{{$studentBalance->purchased_slots / 4}}</td>
                                                        <td>{{$studentBalance->purchased_amount}}</td>
                                                        <td>{{($studentBalance->created_at) ? $studentBalance->created_at->format('F j, Y H:m'): ''}}</td>
                                                        {{--<td style="width:18%;">
                                                            <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                        </td>--}}
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="dker p-a">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"></div>
                                            <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($comprehensiveStudentCollection->currentpage()-1)*$comprehensiveStudentCollection->perpage()+1}} to {{(($comprehensiveStudentCollection->currentpage()-1)*$comprehensiveStudentCollection->perpage())+$comprehensiveStudentCollection->count()}} of {{ $comprehensiveStudentCollection->total() }} items</small> </div>
                                            <div class="col-sm-4 text-right text-center-xs ">
                                                @php
                                                   $crStdparams = request()->toArray();
                                                   $crStdparams['tab'] = 'comprehensiveReport';
                                                   $crStdparams['crTab'] = 'comprehensiveReportStudentTab';
                                                @endphp
                                                {{ $comprehensiveStudentCollection->appends($crStdparams)->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- ############ PAGE END-->
    </div>
@endsection

@section('styles')

@endsection
@section('scripts')

@endsection