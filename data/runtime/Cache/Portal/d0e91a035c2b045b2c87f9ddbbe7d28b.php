<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>模切之家</title>
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="renderer" content="webkit" />
    <script src="//cdn.bootcss.com/angular.js/1.4.9/angular.js"></script>
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/r29/html5.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/tigo-ui.css" type="text/css" />
    <link rel="stylesheet" href="/public/css/style.css" type="text/css" />
    <style>
    .wm-head .back{position:absolute;z-index: 5;}
    </style>

</head>
<body ng-app="myApp" ng-controller="marketCtrl">
<header class="wm-head container">

    <a href="javascript:history.back();" class="back" ></a>
    <a ajax-get  data-action="<?php echo UU('dslist/publish');?>" class="tigo-btn sad-btn right" style="position: absolute;z-index: 5;right: .6rem;">+发布</a>
    <h1 style="top:-.1rem;z-index: 1;">
        <div class="tigo-radio-group sad-radio">
            <label class="check-radio" ng-class="{active:feed}" onclick="return false" ng-click="feed=true;need=false;togglePro(1)" for="gongying">供给<input id="gongying" name="type" type="radio" /> </label>
            <label class="check-radio" ng-class="{active:need}" onclick="return false" ng-click="feed=false;need=true;togglePro(2)" for="xuqiu">需求<input id="xuqiu" name="type" type="radio" /> </label>
        </div>
    </h1>
</header>
<section class="sad-wrapper container clearfix">
    <form action="" method="post"> <div class="tigo-search">

        <span class="search-title" ng-click="openItem()">产品<i class="fa {{iconClass}}"></i></span>
        <input data-search="" type="text" name="keyword" ng-model="ngKeyword" ng-init="ngKeyword=''" />
        <input type="button" class="submit" ng-click="searchCategory()" />

    </div> </form>

    <!--产品列表-->
    <div class="pro-item clearfix" data-bg>
        <!--弹出产品分类-->
        <div class="open-item " ng-style="categoryStyle" >
            <div class="sad-menu">
                <ul class="tab-list">
                    <li ng-click="searchCategory(0)">全部</li>
                    <li ng-repeat="c in categoryParent" ng-click="tabList(c.id);c.active='active'" ng-class="c.active"><a href="javascript:;" ng-bind="c.title"></a></li>
                </ul>
            </div>
            <div class="sad-filter ">
                <div  class="class-item">
                    <blockquote class="caption all">全部</blockquote>
                    <a href="" data-checkbox ng-click="searchCategory(focusParent.id);focusParent.cactive='active'" ng-class="focusParent.cactive">全部</a>
                    <blockquote class="caption " ng-bind="focusParent.title"></blockquote>
                    <div class="sad-sub-filter" >
                        <a href="" data-checkbox ng-repeat="x in categoryChild" ng-bind="x.title" ng-class="x.active" ng-click="searchCategory(x.id);x.active='active';focusParent.cactive='';"></a>
                    </div>
                </div>
            </div>
        </div>
        <div ng-style="loadHTML" style="display: block;text-align: center;padding-top: 2rem;"><i style="font-size: 1.6rem" class="fa fa-spinner fa-spin"></i></div>
        <ul class="product-list market-list" ng-style="contentHTML"  style="display: none;" >
            <li class="clearfix " ng-repeat="x in productList" >
                <div class="pro-right pull-right">
                    <button ajax-get data-action='<?php echo U("user/favorite/do_dsfav");?>&id={{x.id}}' data-html="已关注"  type="button" class="tigo-btn gz">{{x.isfav}}</button>
                    <a href="tel:{{x.mobile}}"><button type="button" class="tigo-btn phone"><i class="fa fa-phone "></i> </button></a>
                </div>
                <div class="pro-left ">
                    <a href="{{x.url}}">
                    <img class="img" src="{{x.img1}}" />
                    <h3 class="title" ><span class="type">{{x.ds}}</span> <span ng-bind="x.title"></span></h3>
                    <h5 class="tags"><span ng-repeat="n in x.tags" ng-bind="n.title"></span></h5>
                    <h5 class="price" ng-if="x.ds == '需'">{{x.num}}{{x.unit}}</h5>
	                <h5 class="price" ng-if="x.ds == '供' && x.price != '面议'">{{x.price}}元/{{x.unit}}</h5>
	                <h5 class="price" ng-if="x.ds == '供' && x.price == '面议'">{{x.price}}</h5>
					</a>
                </div>
                <h5 class="other flex-between"><div ng-if="x.ds == '供' ">{{x.companyname}}</div> <div ng-if="x.ds == '需' && x.switch==1 ">{{x.companyname}}</div> <div ng-if="x.ds == '需' && x.switch==0 "></div> <div ng-bind="x.post_modified"></div></h5>
            </li>
        </ul>
    </div>
</section>

<!---底部导航   start--->
<footer class="footer">
    <dl class="nav-list">
        <a href="<?php echo UU('index/index');?>">
            <dd data-nav-home><!--<img src="images/nav_01.png" />--> </dd>
            <dt>首页</dt>
        </a>
    </dl>
    <dl class="nav-list active">
        <a href="<?php echo UU('dslist/dslist');?>" >
            <dd data-nav-market><!--<img src="images/nav_02.png" /> --></dd>
            <dt>商城</dt>
        </a>
    </dl>
    <dl class="nav-list">
        <a href="<?php echo UU('posts/news');?>" >
            <dd data-nav-news></dd>
            <dt>资讯</dt>
        </a>
    </dl>
    <!-- yhx 20160510 -->
    <dl class="nav-list">
        <a href="<?php echo UU('mine/index');?>" >
            <dd data-nav-my></dd>
            <dt>我的</dt>
        </a>
    </dl>
</footer>
<!---底部导航   end-->
</body>
<script type="text/javascript" module="myApp" src="/public/angular.tips.js"></script>
<script>
    //app = angular.module("myApp",[]);
    app.controller("marketCtrl",function($scope,$location,$http){
        $scope.termId = ""; //初始化筛选分类ID
		$scope.ngKeyword = '<?php echo ((isset($_GET['name']) && ($_GET['name'] !== ""))?($_GET['name']):""); ?>';	//初始化筛选关键字
        /*$http.get('<?php echo U("dslist/filter_dslist");?>&ds=1').success(function(data){
            $scope.productList = data;
            $scope.loadHTML = {"display":"none"}
            $scope.contentHTML = {"display":"block"}
        })*/
        //var prolist = {}
        // var prolist = [[
        //     {
        //         title: "韩国裕屋UY-935保护膜0.25MM1111",
        //         img1: "/test/moqie/public/images/menu_02.png",
        //         price: "300",
        //         unit: "份",
        //         companyname: "东莞市模切之家",
        //         post_modified: "2016-03-20"
        //     }, {
        //         title: "韩国裕屋2222222222222234534",
        //         img1: "/test/moqie/public/images/menu_02.png",
        //         price: "500",
        //         unit: "份",
        //         companyname: "东莞市模切之家",
        //         post_modified: "2016-03-21"
        //     }
        // 
        // ]
        //设置默认展现数量为 10
        $scope.showNums = 1;
        if($location.hash()=="need"){
            $scope.feed = false;
            $scope.need = true;
            $scope.productType = 2;
            //$scope.productList = prolist[1];
            $http.get('<?php echo U("dslist/filter_dslist");?>&ds=2&name='+$scope.ngKeyword).success(function(data){
                $scope.productList = data;
                $scope.loadHTML = {"display":"none"}
                $scope.contentHTML = {"display":"block"}
            })
        }else {
            $scope.feed = true;
            $scope.need = false;
            //$scope.productList = prolist[0];
            $scope.productType = 1;
            $http.get('<?php echo U("dslist/filter_dslist");?>&ds=1&name='+$scope.ngKeyword).success(function(data){
                $scope.productList = data;
                $scope.loadHTML = {"display":"none"}
                $scope.contentHTML = {"display":"block"}
            })
        }
        //切换供给与需求
        $scope.togglePro = function(n){
            console.log(n);
            $http.get('<?php echo U("dslist/filter_dslist");?>&ds='+n).success(function(data){
                $scope.productList = data;
                $scope.loadHTML = {"display":"none"}
                $scope.contentHTML = {"display":"block"}
            })
            $scope.productType = n;
            $scope.showNums = 1;
        }

        //弹出筛选分类层
        $scope.openHide = true;
        $scope.iconClass = "fa-angle-down";
        $scope.openItem = function(){
            if($scope.openHide){
                $scope.categoryStyle = {'display':'block'}
                $scope.iconClass = "fa-angle-up";
            }else{
                $scope.categoryStyle = {'display':'none'}
                $scope.iconClass = "fa-angle-down";
            }
            $scope.openHide = !$scope.openHide;
        }

        //分类
        var categoryList = <?php echo ($terms); ?>;
        var crParent = [],crChild = [];
        angular.forEach(categoryList,function(data){
            if(data.parent_id==0) {
                crParent.push(data);
            }
            if(categoryList[0].id == data.parent_id){
                crChild.push(data)
            }
        })
        crParent[0].active = "active";
        $scope.focusParent =crParent[0];
        $scope.categoryParent = crParent;
        $scope.categoryChild = crChild;
        $scope.tabListId = crParent[0].id;
        $scope.tabListId;
        //弹出层 子父分类tab选项
        $scope.tabList = function(id){
            //console.log(id);
            crChild = [];
            angular.forEach(categoryList,function(data){
                if(data.id == id) {
                    $scope.focusParent =data;       //被选择分类赋值
                }
                data.active = null;
                if(data.parent_id == id){
                    crChild.push(data);             //子分类数组
                }
            })
            //console.log($scope.focusParent);
            $scope.categoryChild = crChild;
        }
        //筛选分类 列出产品
        $scope.searchCategory = function(id){
            
            if(id || id==0){
                $scope.termId = id;
            }
            $scope.openHide = true;
            $scope.categoryStyle = {'display':'none'}
            $scope.iconClass = "fa-angle-down";
            $http.get("<?php echo U('portal/dslist/filter_dslist');?>&termid="+$scope.termId+"&ds="+$scope.productType+"&name="+$scope.ngKeyword).success(function(data){
                $scope.productList = data/*[
                    {
                        title: "韩国裕5555555555555",
                        img1: "/test/moqie/public/images/menu_02.png",
                        price: "300",
                        unit: "份",
                        companyname: "东莞市模切之家",
                        post_modified: "2016-03-20"
                    }, {
                        title: "韩国66666666666666666",
                        img1: "/test/moqie/public/images/menu_02.png",
                        price: "500",
                        unit: "份",
                        companyname: "东莞市模切之家",
                        post_modified: "2016-03-21"
                    }
                ]*/
            });
            angular.forEach($scope.categoryChild,function(data){
                data.active = null;
            })
        }

        //滚动加载事件
        window.onscroll = function() {
            var htmlHeight = document.body.scrollHeight;
            var clientHeight = document.body.clientHeight;
            var scrollHeight = document.body.scrollTop;
            if((scrollHeight+clientHeight) == htmlHeight){
                 $http.get("<?php echo U('portal/dslist/filter_dslist');?>&termid="+$scope.termId+"&ds="+$scope.productType+"&name="+$scope.ngKeyword+"&page="+($scope.showNums+1)).success(function(data){
                    if(data){
                        $scope.showNums++;
                    }
                    $scope.productList = $scope.productList.concat(data);
                });
            }
        }
    })
</script>
</html>