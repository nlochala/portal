@extends('layouts.backend')

@section('content')
    @include('layouts._content_start')
    <!--
    panel.row
    panel.column
    panel.panel
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel
    panel.row

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->

    @foreach($students as $student)
        @if(!$student->family || $student->family->guardians->isEmpty()) @continue @endif
        <div class="float-right">
            <strong>{{ $student->person->fullName() }} - {{ $student->gradeLevel->name }}</strong>
        </div> <br />
        <div style="text-align: center">
            <img src="/storage/parent_portal_welcome_head.png" class="img-fluid options-item">
        </div>
        <br/>
        <h1 class="flex-sm-fill font-size-h3 font-w400 mt-2 mb-0 mb-sm-2">Welcome to the tlcPORTAL!</h1>
        <br/>
        <strong>Dear parents,</strong><br/>
        <p>We are pleased to announce a new way for you to stay up-to-date on your students' progress and to be informed
            of different events and activities going on here at TLC. The tlcPORTAL is on online application you can log
            in to from anywhere in the world. It shows detailed, real-time information concerning your students' grades
            and progress in each class. From the portal you can easily send messages and communicate with each of your
            students' teachers as well. We have many wonderful features planned for the portal, all with the purpose of
            allowing parents even more ways of being active and involved in your students' education here at TLC.</p>

        <p>In order for you to successfully log into the tlcPORTAL, please go to: https://portal.tlcdg.com</p>

        <p>You will be redirected to a login page in which you will use the following credentials:<br/>
            @foreach($student->family->guardians as $guardian)
                <strong>{{ $guardian->person->extendedName() }}</strong><br/>
                Username: <code>{{ $guardian->username }}</code><br/>
                Password: <code>{{ $guardian->password }}</code><br/><br/>
            @endforeach

            If you have any trouble or questions, please send an email to <a href="mailto:parent-portal@tlcdg.com">parent-portal@tlcdg.com</a>.<br/>
            Sincerely,<br/>
            TLC Administration
        </p>
        <hr/>
        <hr/>
        <strong>亲爱的家长们：</strong><br/>
        <p>我们很高兴地宣布能让您随时了解您孩子的最新动态，并了解TLC正在举办的各种活动的新方式-tlcPORTAL，它是在线应用程序，您可以在世界任何地方登录。它显示您孩子每科的成绩和近况的详细的实时信息。您也可以通过Portal轻松地发送消息与您孩子的各科老师进行交流。我们为Portal网站设计了很多很棒的功能，目的是让家长们有更多的方式积极地参与到TLC学生的教育中来。</p>

        <p>想成功登入tlcPORTAL，请输入以下网址: https://portal.tlcdg.com</p>

        <p>输入后会跳转到登陆页面，您需要使用如下信息：<br />
            @foreach($student->family->guardians as $guardian)
                <strong>{{ $guardian->person->extendedName() }}</strong><br/>
                用户名: <code>{{ $guardian->username }}</code><br/>
                密码: <code>{{ $guardian->password }}</code><br/><br/>
            @endforeach

            如果您有任何问题，请发邮件至<a href="mailto:parent-portal@tlcdg.com">parent-portal@tlcdg.com</a>。<br />
            Sincerely, <br />
            TLC行政管理办公室 </p>
        <br/>
        <br/>
        <div style="text-align: center">
            <img src="/storage/report_card_20192020_foot.png" class="img-fluid options-item">
        </div>
        <div class="page-break"></div>
    @endforeach
    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {

            Dashmix.helpers(['print']);
            // setTimeout('closePrintView()', 3000);

        });

        function closePrintView() {
            window.location.href = '{!! request()->getRequestUri() !!}';
        }
    </script>
@endsection
