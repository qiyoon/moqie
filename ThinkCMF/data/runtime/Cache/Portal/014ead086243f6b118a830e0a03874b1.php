<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <title>模切之家</title>
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="renderer" content="webkit" />
    <script src="//cdn.bootcss.com/angular.js/1.5.0/angular.js"></script>
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/r29/html5.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/tigo-ui.css" type="text/css" />
    <link rel="stylesheet" href="/public/css/style.css" type="text/css" />

</head>
<body ng-app="myApp" ng-controller="publishCtrl">
<header class="wm-head container">
    <a class="back" href="javascript:history.back();" ></a>
    <h1>
        我要发布
    </h1>
</header>
<div class="clearfix publish-top" ><h3 class="pull-left text-center {{gy.color}}" ng-click="gongyingBtn()" >发供应<i class="fa {{gy.icon}}"></i> </h3><h3 ng-click="xuqiuBtn()" class="pull-right text-center {{xq.color}}">发需求<i class="fa {{xq.icon}}"></i></h3></div>
<section class="publish-wrapper container">
    <form ng-hide="gy.hide" action="do_publish" method="post">
        <div class="tigo-input-group publish-input">
            <label>企业名称</label> <input class="input-item" name="companyname" type="text"  value="东莞市模切之家有限公司">
        </div>
        <div class="tigo-input-group publish-input">
            <input type="hidden" name="termid"  value="{{categoryId}}">
            <select class="category-select" ng-style="childStyle"  ng-model="resId" ng-change="childSelect()">
                <option ng-repeat="a in childOption" name="termid" value="{{a.id}}">{{a.title}}</option>
            </select>
            <select class="category-select" ng-style="parentStyle"  ng-model="cid" ng-change="selectChange()">
                <option ng-repeat="x in categoryList" ng-bind="x.title" name="termid" ng-value="x.id" ></option>
            </select>
            <label>选择类别</label>  <div class="input-item text-right" ng-click="showSelect()"> <span ng-init="categoryTitle='全部'" ng-bind="categoryTitle">全部</span>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;&nbsp;</div>
        </div>
        <div class="tigo-input-group publish-input">
            <label>标题</label> <input class="input-item" name="title" type="text" placeholder="请输入标题">
        </div>
        <div class="tigo-input-group publish-input">
            <label>价格</label> <input class="input-item" name="price" type="text" placeholder="请输入价格">
        </div>
        <div class="tigo-input-group publish-input">
            <label>标签</label> <input class="input-item" name="tag" type="text" placeholder="请输入标签">
        </div>
        <div class="tigo-input-group publish-input">
            <textarea class="input-item" name="content" style="border: solid 0.05rem #ddd;background: #eee;height: 6.5rem" placeholder="请在这里描述您的需求!"></textarea>
        </div>
        <div class="tigo-input-group publish-input">
            <input type="hidden" name="type" value="feed" />
            <button type="submit" class="submit-btn">确定</button>
        </div>
    </form>
    <form ng-hide="xq.hide" action="do_publish" method="post">
        <div class="tigo-input-group publish-input">
            <label>企业名称</label> <input class="input-item" type="text" name="companyname"  value="东莞市模切之家有限公司">
            <div class="tigo-turn-circle publish-circle" ng-click="pubSwitch()">
                <div class="tigo-turn" name="turn" ng-style="switchStyle"></div>
                <input type="hidden" name="switch" value="{{switchVal}}" />
            </div>
        </div>
        <div class="tigo-input-group publish-input">
            <input type="hidden" name="termid" value="{{categoryId}}">
            <select class="category-select" ng-style="childStyle"  ng-model="resId" ng-change="childSelect()">
                <option ng-repeat="a in childOption" name="termid" value="{{a.id}}">{{a.title}}</option>
            </select>
            <select class="category-select" ng-style="parentStyle"  ng-model="cid" ng-change="selectChange()">
                <option ng-repeat="x in categoryList" ng-bind="x.title" name="termid" ng-value="x.id" ></option>
            </select>
            <label>选择类别</label>  <div class="input-item text-right" ng-click="showSelect()"> <span ng-init="categoryTitle='全部'" ng-bind="categoryTitle">全部</span>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;&nbsp;</div>
        </div>
        <div class="tigo-input-group publish-input">
            <label>标题</label> <input class="input-item" name="title" type="text" placeholder="请输入标题">
        </div>
        <div class="tigo-input-group publish-input">
            <label>数量</label> <input class="input-item" name="num"  type="text" placeholder="请输入数量">
        </div>
        <div class="tigo-input-group publish-input">
            <label>单位</label> <input class="input-item" name="unit" type="text" placeholder="请输入单位">
        </div>
        <div class="tigo-input-group publish-input">
            <label>标签</label> <input class="input-item" name="tag" type="text" placeholder="请输入标签">
        </div>
        <div class="tigo-input-group publish-input">
            <textarea class="input-item" name="content" style="border: solid 0.05rem #ddd;background: #eee;height: 6.5rem" placeholder="请在这里描述您的需求!"></textarea>
        </div>
        <div class="tigo-input-group publish-input">
            <input type="hidden" name="type" value="need" />
            <button type="submit" class="submit-btn">确定</button>
        </div>
    </form>
</section>
<footer class="footer">
    <dl class="nav-list">
        <a href="index.html">
            <dd data-nav-home><!--<img src="images/nav_01.png" />--> </dd>
            <dt>首页</dt>
        </a>
    </dl>
    <dl class="nav-list active">
        <a href="market.html" >
            <dd data-nav-market><!--<img src="images/nav_02.png" /> --></dd>
            <dt>商场</dt>
        </a>
    </dl>
    <dl class="nav-list">
        <a href="news.html" >
            <dd data-nav-news></dd>
            <dt>资讯</dt>
        </a>
    </dl>
    <dl class="nav-list">
        <a href="member.html" >
            <dd data-nav-my></dd>
            <dt>我的</dt>
        </a>
    </dl>
</footer>
</body>
<script>
    var app = angular.module("myApp",[]);
    app.controller("publishCtrl",function($scope){
        $scope.gy = {
            hide:false,
            icon:"fa-angle-up",
            color:"text-red"
        }
        $scope.xq  = {
            hide:true,
            icon:"fa-angle-down",
            color:""
        }
        $scope.gongyingBtn = function(){
            $scope.xq = {
                hide:true,
                icon:"fa-angle-down",
                color:""
            };
            $scope.gy = {
                hide:false,
                icon:"fa-angle-up",
                color:"text-red"
            };
        }
        $scope.xuqiuBtn = function(){
            $scope.gy = {
                hide:true,
                icon:"fa-angle-down",
                color:""
            };
            $scope.xq = {
                hide:false,
                icon:"fa-angle-up",
                color:"text-red"
            };
        }
        $scope.turnCircle = false;
        $scope.circle = function(a,c){
            $scope.turnCircle = !$scope.turnCircle;
            $scope.input = '<input type="turn" value="'+($scope.turnCircle?a:c)+'" />'
        }
        var categoryLists = angular.fromJson('<?php echo (json_encode($terms)); ?>');
            /* [
            {title:"一级分类1",id:1,parent_id:0},
            {title:"一级分类2",id:2,parent_id:0},
            {title:"一级分类3",id:3,parent_id:0},
            {title:"一级分类4",id:4,parent_id:0},
            {title:"一级分类5",id:5,parent_id:0},
            {title:"一级分类6",id:6,parent_id:0},
            {title:"二级分类7",id:7,parent_id:0},
            {title:"二级分类8",id:8,parent_id:1},
            {title:"二级分类9",id:9,parent_id:2},
            {title:"二级分类10",id:10,parent_id:3},
            {title:"二级分类11",id:11,parent_id:4},
            {title:"二级分类12",id:12,parent_id:1}
        ]*/
        //分类初始化
        var initCate = [];
        angular.forEach(categoryLists,function(data){
            if(data.parent_id==0){
                initCate.push(data);
            }
        })
        $scope.categoryList = initCate;

        $scope.selectChange = function(){
            $scope.categoryId = $scope.cid;   //获得父分类ID
            var cates = [] ;
            $scope.childStyle = {"z-index":"999"}
            $scope.parentStyle = {"z-index":"888"}
            cates.push({title:"上一级",id:$scope.cid});
            angular.forEach(categoryLists,function(data){
                if($scope.cid==data.id){
                    $scope.categoryTitle = data.title;
                }
                if($scope.cid == data.parent_id){
                    cates.push(data);
                }
            })
            $scope.childOption = cates;
            //console.log($scope.categoryChild);
        }
        $scope.childSelect = function(){
            /*if($scope.categoryId == $scope.resId){
            }else {*/

                $scope.childStyle = {"z-index":"888"}
                $scope.parentStyle = {"z-index":"999"}
                $scope.categoryId = $scope.resId;   //获得子分类ID
            //}
            angular.forEach(categoryLists,function(data){
                if($scope.resId==data.id){
                    $scope.categoryTitle = data.title;
                }

            })
        }

        //发布需求是否显示公司名称
        var switchT = true;
        $scope.pubSwitch =  function(){
            switchT = !switchT;
            if(switchT) {
                $scope.switchStyle = {"float": "left"};
                $scope.switchVal = 1;
            }else{
                $scope.switchStyle = {"float": "right"};
                $scope.switchVal = 0;
            }
        }
    })
</script>
</html>