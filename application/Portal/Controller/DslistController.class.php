<?php
// +----------------------------------------------------------------------
// | TIGO [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.tigonetwork.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: YHX
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomebaseController;
/**
 * 供需控制器
 */
class DslistController extends HomebaseController {

    /**
     * 分类递归
     * @Author   YHX
     * @DateTime 2016-05-04T15:15:55+0800
     * @param    [type]                   $array [description]
     * @param    integer                  $pid   [description]
     * @return   [type]                          [description]
     */
    function myorder ($array,$pid=0){
        $arr = array();

        foreach($array as $v){
            if($v['parent']==$pid){
                $arr[] = $v;
                $arr = array_merge($arr,$this->myorder($array,$v['term_id']));
            }
        }
        return $arr;
    }



    /**
     * 供需默认列表
     * @Author   YHX
     * @DateTime 2016-05-03T17:07:05+0800
     * @return   [type]                   [description]
     */
    public function dslist(){
        $user_model = M("Users");

        //分类列表
        $terms_obj = M('Terms');
        $order = "listorder ASC";
        $terms=$terms_obj->where("taxonomy='dslist' AND path like '0-2-6-%'")->order($order)->field('term_id as id,name as title ,parent as parent_id')->select();
        foreach ($terms as $k => $v) {
            if($v['parent_id']==6){
                $terms[$k]['parent_id']=0;
            }
        }
        //查询条件 供应
        $map['post_status']  = 1;
        $_GET['name'] ? $map['post_title']=array('like','%'.$_GET['name'].'%') : "";
        $_GET['termid'] ? $map['term_id']=$_GET['termid'] : "";
        $map['ds']=1;//判断供需
//        dump($_GET);die();

        //最新供应
        $limit1 = 10;
        $term_relationships_model = M('TermRelationships');
        $dslist=$term_relationships_model
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."dslist b ON a.object_id = b.id")
            ->limit('0,'.$limit1)
            ->where($map)
            // ->field('post_title as title,post_keywords as content,post_modified as time,price,unit as prefix,img1 as cover')
            ->field('term_id,post_title as title,post_keywords as content,id,post_hits,smeta,post_modified,tag,ds,post_author,price,unit,img1,img2')
            ->order("a.listorder ASC,b.post_modified DESC")->select();

        //关注列表
        $uid= sp_get_current_user();
        $fav_model = M("UserFavorites");
        $favlist = $fav_model->where(array("uid"=>$uid['id'],"table"=>"dslist"))->select();

        //处理数据
        foreach($dslist as $k => $v){
            $dslist[$k]["content"] = mb_substr($v["content"],0,100,'utf-8');
//            $dslist[$k]["post_modified"] =  number_format(((time() - strtotime($v["post_modified"]))/86400),1,'.','');
//            $tmp =json_decode($v["smeta"]);
            if($v["img1"]==null || $v["img1"]==""){
                $dslist[$k]["img1"]=C("TMPL_PARSE_STRING.__UPLOAD__")."nopic.gif";
            }else{
                $dslist[$k]["img1"]="/". $v["img1"];
            }
            $user = $user_model->where("id=".$v['post_author'])->find();
            $dslist[$k]["companyname"]=$user['companyname'];
            $dslist[$k]["mobile"]=$user['mobile'];
            $dslist[$k]["ds"]= $v["ds"]==1?"供":"需";//供需标签
            $dslist[$k]['url']=U("portal/dslist/dslist_detail",array('id'=>$v["id"]));
            //tag处理
            $tags = explode(',',preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/" ,',' ,$v['tag']));
            foreach($tags as $k1 => $v1){
                if($v1){
                    $dslist[$k]["tags"][$k1]["title"] = $v1;
                }
            }
            $dslist[$k]['isfav'] = 0;//未关注返回0
            //处理是否已经关注
            if($favlist){
                foreach($favlist as $k2 => $v2){
                    if($v['id']==$v2['object_id']){
                        $dslist[$k]['isfav'] = 1;//已关注返回1
                    }
                }
            }
        }

        //查询条件 需求
        $map1['post_status']  = 1;
        $_GET['name'] ? $map1['post_title']=array('like','%'.$_GET['name'].'%') : "";
        $_GET['termid'] ? $map1['term_id']=$_GET['termid'] : "";
        $map1['ds']=2;//判断供需

        //最新需求
        // $limit1 = 10;
        $term_relationships_model = M('TermRelationships');
        $dslist1=$term_relationships_model
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."dslist b ON a.object_id = b.id")
            ->limit('0,'.$limit1)
            ->where($map1)
            // ->field('post_title as title,post_keywords as content,post_modified as time,price,unit as prefix,img1 as cover')
            ->field('term_id,post_title as title,post_keywords as content,id,post_hits,smeta,post_modified,tag,ds,post_author,price,unit,img1,img2')
            ->order("a.listorder ASC,b.post_modified DESC")->select();

        //关注列表
        $uid= sp_get_current_user();
        $fav_model = M("UserFavorites");
        $favlist = $fav_model->where(array("uid"=>$uid['id'],"table"=>"dslist1"))->select();

        //处理数据
        foreach($dslist1 as $k => $v){
            $dslist1[$k]["content"] = mb_substr($v["content"],0,100,'utf-8');
//            $dslist1[$k]["post_modified"] =  number_format(((time() - strtotime($v["post_modified"]))/86400),1,'.','');
//            $tmp =json_decode($v["smeta"]);
            if($v["img1"]==null || $v["img1"]==""){
                $dslist1[$k]["img1"]=C("TMPL_PARSE_STRING.__UPLOAD__")."nopic.gif";
            }else{
                $dslist1[$k]["img1"]="/". $v["img1"];
            }
            $user = $user_model->where("id=".$v['post_author'])->find();
            $dslist1[$k]["companyname"]=$user['companyname'];
            $dslist1[$k]["mobile"]=$user['mobile'];
            $dslist1[$k]["ds"]= $v["ds"]==1?"供":"需";//供需标签
            $dslist1[$k]['url']=U("portal/dslist/dslist_detail",array('id'=>$v["id"]));
            //tag处理
            $tags = explode(',',preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/" ,',' ,$v['tag']));
            foreach($tags as $k1 => $v1){
                if($v1){
                    $dslist[$k]["tags"][$k1]["title"] = $v1;
                }
            }
            $dslist1[$k]['isfav'] = 0;//未关注返回0
            //处理是否已经关注
            if($favlist){
                foreach($favlist as $k2 => $v2){
                    if($v['id']==$v2['object_id']){
                        $dslist1[$k]['isfav'] = 1;//已关注返回1
                    }
                }
            }
        }



        //组装数组并转化为json格式
        $tmp = array($dslist,$dslist1);
        $ds_json = json_encode($tmp);
        $terms = json_encode($terms);
        // dump($tmp);die();
        // echo $tmp ;die();

        $this->assign('terms',$terms);
        $this->assign('dslist',$ds_json);
        $this->display(":market");

    }
    /**
     * 供需默认列表上拉加载
     * @Author   YHX
     * @DateTime 2016-05-03T18:16:09+0800
     * @return   [type]                   [description]
     */
    public function dslist_getauto(){

        $page = intval($_GET['page']);  //获取请求的页数

        //查询条件
        $map['post_status']  = 1;
        $where_name =$_GET['name'] ? $map['post_title']=array('like','%'.$_GET['name'].'%') : "";
        $where_termid =$_GET['termid'] ? $map['term_id']=$_GET['termid'] : "";


        $start =$page*10;//偏移量


        // $dslist_obj = M('Dslist');
        // $order = "post_modified Desc";
        $limit = 10;

        $term_relationships_model = M('TermRelationships');
        $dslist=$term_relationships_model
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."dslist b ON a.object_id = b.id")
            ->limit($start,$limit)
            ->where($map)
            ->order("a.listorder ASC,b.post_modified DESC")->select();

        // $dslist=$dslist_obj->where("post_status=1")->order($order)->limit($start,$limit)->select();
        echo json_encode($dslist);  //转换为json数据输出
    }


    /**
     * 需求详情页
     * @Author   YHX
     * @DateTime 2016-05-04T15:46:53+0800
     * @return   [type]                   [description]
     */
    public function dslist_detail(){
        $id = intval($_GET['id']);  //获取请求的id
        	
        $dslist_model = M('Dslist');
        $dslist = $dslist_model
        ->alias("a")
        ->join(C ( 'DB_PREFIX' )."users b ON a.post_author = b.id")
        ->field('a.id,avatar,post_title,post_content,a.companyname,specification,description,num,switch,img1,img2,ds,unit,truename,mobile,price,tag,address')
        ->where(array("a.id"=>$id))->find();
        if($dslist['img1']==null || $dslist['img1']==""){
            $dslist['img1']=C("TMPL_PARSE_STRING.__UPLOAD__")."nopic.gif";
        }else{
            $dslist['img1']="/".$dslist['img1'];
        }
        if($dslist['img2']==null || $dslist['img2']==""){
            $dslist['img2']=C("TMPL_PARSE_STRING.__UPLOAD__")."nopic.gif";
        }else{
            $dslist['img2']="/".$dslist['img2'];
        }
        //判断是否加关注
        $fav_model = M("UserFavorites");
        $fav = $fav_model->where(array("object_id"=>$id,"uid"=>sp_get_current_userid()))->find();
        if($fav){
        	$dslist['isfav'] ="已关注";
        }
        else{
        	$dslist['isfav'] ="+关注";
        }
        //tag处理
        $tags = explode(',',preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/" ,',' ,$dslist['tag']));
        foreach($tags as $k1 => $v1){
            if($v1){
                $dslist["tags"][$k1]["title"] = $v1;
            }
        }
         //dump($dslist);die();

        $this->assign('dslist',$dslist);
        if($dslist['ds']==1){
            $this->display(":proinfo");
        }
        elseif ($dslist['ds']==2) {
            $this->display(":proinfo2");
        }
        
    }

    /**
     * 发布页
     * @Author   YHX
     * @DateTime 2016-05-06T14:45:21+0800
     * @return   [type]                   [description]
     */
    public function publish(){
    	//未登录不能操作
        if(sp_get_current_userid()==0 || sp_get_current_user()==null){
            // $this->error("请先登录！",U("user/login/index"));
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="请先登录！";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
        }
        //非认证企业用户不能发布
        $user_model = M('Users');
        $user=$user_model->where(array("id"=>sp_get_current_userid()))->find();
        $c_status =$user['company_status'];
        if($c_status!=4){
        	// $this->error("非认证企业用户不能发布",U("portal/dslist/dslist"));
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="非认证企业用户不能发布";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
        }
        //分类列表
        $terms_obj = M('Terms');
        $order = "listorder ASC";
        $terms=$terms_obj->where("taxonomy='dslist' AND path like '0-2-6-%'")->order($order)->field('term_id as id,name as title ,parent as parent_id')->select();
        foreach ($terms as $k => $v) {
            if($v['parent_id']==6){
                $terms[$k]['parent_id']=0;
            }
        }
        // dump($terms);die();
        $uid=sp_get_current_userid();
        $user_obj = M('Users');
        $user = $user_obj->where(array("id"=>$uid))->field("companyname")->find();


        $this->assign("terms",$terms);
        $this->assign("user",$user);
        $this->display(":publish");
    }

    /**
     * 发布信息
     * @Author   YHX
     * @DateTime 2016-05-06T18:00:39+0800
     * @return   [type]                   [description]
     */
    public function do_publish(){
        //未登录不能操作
        if(sp_get_current_userid()==0 || sp_get_current_user()==null){
            // $this->error("请先登录！",U("user/login/index"));
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="请先登录！";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
        }
        if(IS_POST){

            if($_FILES['file1']['name']){
                $filename1 = strtotime(date('Y-m-d')) . '-' . rand(1,9999);
                $data['img1'] = 'Uploads/publish/'. $filename1;
            }
            if($_FILES['file2']['name']){
                $filename2 = strtotime(date('Y-m-d')) . '-' . rand(1,9999);
                $data['img2'] = 'Uploads/publish/'. $filename2;
            }


            $destination1 = './uploads/publish/'. $filename1;
            $destination2 = './uploads/publish/'. $filename2;
            move_uploaded_file( $_FILES['file1']['tmp_name'] , $destination1 );
            move_uploaded_file( $_FILES['file2']['tmp_name'] , $destination2 );

            $data['companyname'] = $_POST["companyname"];
            $data['post_title'] = $_POST["title"];
            $data['switch'] = $_POST["switch"];
            $data['term_id'] = $_POST["term_id"];
            $data['price'] = is_numeric($_POST["price"])?$_POST["price"]:"面议";
            $data['num'] = $_POST["num"];
            $data['unit'] = $_POST["unit"];
            $data['tag'] = $_POST["tag"];
            $data['post_content'] = htmlspecialchars_decode($_POST["content"]);
            $data['ds'] = $_POST["type"];
            // $data['img1'] = $_POST["img1"];
            // $data['img2'] = $_POST["img2"];
            $data['post_date'] =date ( 'Y-m-d H:i:s' );
            $data['post_modified'] =date ( 'Y-m-d H:i:s' );
            $data['post_author']=sp_get_current_userid();
            $data['post_status'] = 0;
            $data['specification'] = $_POST['specification'];


            $dslist_model = M('Dslist');
            $term_relationships_model = M('TermRelationships');
            $result=$dslist_model->add($data);
            
            if ($result) {
				
                $allOk = $term_relationships_model->add(array("term_id"=>intval($data['term_id']),"object_id"=>$result));
                if($allOk){
                	// $this->success("信息添加成功");
                    $tips['status']=1;//0为失败，1为成功
                    $tips['info']="信息发布成功";//错误信息
                    $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('portal/dslist/dslist');//跳转地址,发生错误不需要地址
                    $this->ajaxReturn($tips);
                }
                else{
                	// $this->error("信息添加失败");
                    $tips['status']=0;//0为失败，1为成功
                    $tips['info']="信息添加失败";//错误信息
                    // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
                    $this->ajaxReturn($tips);
                }
            } else {
                // echo 0;
                // $this->error("信息添加失败");
                $tips['status']=0;//0为失败，1为成功
                $tips['info']="信息添加失败";//错误信息
                // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
                $this->ajaxReturn($tips);
            }
        }
    }
    
    /**
     * 筛选供需列表
     * @Author   jewey
     * @DateTime 2016-05-13T14:07:05+0800
     * @return   [type]                   [description]
     *
     * get讲求传入的数据有
     * 1、page 页数，从1开始
     * 2、name 产品标题
     * 3、termid 分类id
     * 4、ds为供需类型，1为供，2为需
     */
    public function filter_dslist()
    {
        $user_model = M("Users");
        //查询条件 供应
        if (isset($_GET['page']) && trim($_GET['page']) != '') {
            $page = intval($_GET['page'])-1;  //获取请求的页数,
        }else{
            $page = 0;
        }

        $limit = 10;//偏移量
        $start =$page*$limit;
        
        $map['post_status']  = 1;//已审核才显示
        if (isset($_GET['name']) && trim($_GET['name']!='')) {//
            $map['post_title']=array('like','%'.$_GET['name'].'%');
        }
        if (isset($_GET['termid']) && trim($_GET['termid']!='')) {
        	if($_GET['termid']<30){
        		$map['path']=array('like','%'.$_GET['termid'].'%');
        	}
        	else{
        		$map['a.term_id']=$_GET['termid'];
        	}
        }else{
			$map['a.term_id'] =array("gt",5);
		}
        if (isset($_GET['ds']) && trim($_GET['ds']!='')) {
            $map['ds']=$_GET['ds'];//获取供或需
        }
        
        
        // dump($start);
        // dump($map);die();        
       // dump($_GET);
       // die();

        //最新供应

        $term_relationships_model = M('TermRelationships');
        $dslist=$term_relationships_model
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."dslist b ON a.object_id = b.id")
			->join(C ( 'DB_PREFIX' )."terms c ON a.term_id = c.term_id")
            ->limit($start,$limit)
            ->where($map)
            // ->field('post_title as title,post_keywords as content,post_modified as time,price,unit as prefix,img1 as cover,companyname')
            ->field('a.term_id,post_title as title,post_keywords as content,id,post_hits,smeta,post_modified,tag,ds,post_author,price,unit,img1,img2,companyname,switch,num')
            ->order("a.listorder ASC,b.post_modified DESC")->select();

        //关注列表
        $uid= sp_get_current_user();
        $fav_model = M("UserFavorites");
        $favlist = $fav_model->where(array("uid"=>$uid['id'],"table"=>"dslist"))->select();

        //处理数据
        foreach($dslist as $k => $v){
            $dslist[$k]["content"] = mb_substr($v["content"],0,100,'utf-8');
//            $dslist[$k]["post_modified"] =  number_format(((time() - strtotime($v["post_modified"]))/86400),1,'.','');
//            $tmp =json_decode($v["smeta"]);
            if($v["img1"]==null || $v["img1"]==""){
                $dslist[$k]["img1"]=C("TMPL_PARSE_STRING.__UPLOAD__")."nopic.gif";
            }else{
                $dslist[$k]["img1"]="/" .$v["img1"];
            }
            $user = $user_model->where("id=".$v['post_author'])->find();
            //$dslist[$k]["companyname"]=$user['companyname'];
            $dslist[$k]["mobile"]=$user['mobile'];
            $dslist[$k]["ds"]= $v["ds"]==1?"供":"需";//供需标签
            $dslist[$k]['url']=U("portal/dslist/dslist_detail",array('id'=>$v["id"]));
            //tag处理
            $tags = explode(',',preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/" ,',' ,$v['tag']));
            //echo(preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/" ,',' ,$v['tag']));die();
            foreach($tags as $k1 => $v1){
                if($v1){
                    $dslist[$k]["tags"][$k1]["title"] = $v1;
                }
            }
            $dslist[$k]['isfav'] = '+关注';//未关注返回0
            //处理是否已经关注
            if($favlist){
                foreach($favlist as $k2 => $v2){
                    if($v['id']==$v2['object_id']){
                        $dslist[$k]['isfav'] = '已关注';//已关注返回1
                    }
                }
            }
        }
	echo json_encode(($dslist));
	exit();	
/*		
		if(IS_AJAX){
			echo json_encode(($dslist));
			exit();				
		}else{
			$this->assign('dslist',$dslist);
			$this->display(":market");		
		}
  */
    }
    
    //YHX20160514 拿样页面
    function sample(){
    	//如果没有登录不能拿样
        if(!sp_is_user_login()) {
            // $this->error("请先登录","/user/login/index");
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="请先登录";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
        }
    	$uid = sp_get_current_userid();
        $user_model = M("Users");
        $user = $user_model->where(array("id"=>$uid))->find();
    	$id = $_GET["id"];
    	if($id==null || $id=="" || $id=="0"){
    		// $this->error("数据错误");
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="数据错误";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
    	}
    	$this->assign("object_id",$id);
    	$this->assign("user",$user);
    	$this->display(":proneed");
    }
    
    //YHX20160514 拿样
    function do_sample(){
    	//如果没有登录不能拿样
    	$uid = sp_get_current_userid();
        if(!sp_is_user_login()) {
            // $this->error("请先登录","/user/login/index");
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="请先登录";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
        }
        
        if(!IS_POST){
        	// $this->error("非法数据","/user/login/index");
            $tips['status']=0;//0为失败，1为成功
            $tips['info']="非法数据";//错误信息
            // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
            $this->ajaxReturn($tips);
        }
        else{
        	$picker = $_POST['picker'];
        	$companyname = $_POST['companyname'];
        	$mobile = $_POST['mobile'];
        	$address = $_POST['address'];
        	$uid = $uid;
        	$object_id = $_POST['object_id'];
        	$addtime = date ( 'Y-m-d H:i:s' );
        	
        	$data['picker'] = $picker;
        	$data['companyname'] = $companyname;
        	$data['re_address'] = $address;
        	$data['uid'] = $uid;
        	$data['object_id'] = $object_id;
        	$data['addtime'] = $addtime;
        	$data['mobile'] = $mobile;
        	
        	$sample_model =M('Sample');
        	//判断是否已经拿过该产品
        	$is_pick = $sample_model->where(array("uid"=>$uid,"object_id"=>$object_id))->find();
        	if($is_pick){
        		// $this->error("你已申请过改产品！");
                $tips['status']=0;//0为失败，1为成功
                $tips['info']="你已申请过改产品！";//错误信息
                // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
                $this->ajaxReturn($tips);
        	}else{
        		$sample = $sample_model->add($data);
	        	if($sample){
	        		//发送信息给供应商
	        		//获取供应商的userid,产品名
	        		$dslist_model = M('Dslist');
	        		$dslist =$dslist_model->where(array("id"=>$object_id))->find();
	        		$feed_uid=$dslist['post_author'];
	        		$feed_title=$dslist['post_title'];
	        		//获取供应商的电话,公司名，nicename
	        		$user_model = M('Users');
	        		$feed = $user_model->where(array("id"=>$feed_uid))->find();
	        		$feed_mobile = $feed['mobile'];
	        		//dump($feed);die();
	        		//$feed_companyname = $feed['companyname'];
	        		//$feed_nicename = $feed['user_nicename'];
	        		//拼装短信内容
	        		$contents="拿样通知:".$companyname."的".$picker."先生"."提交了".$feed_title."产品的拿样申请，电话为".$mobile."，地址为".$address."，请尽快处理！";
	        		//发送短信
	        		$result=$this->send_sample_sms($feed_mobile,$contents);
	        		if($result>0){
	        			// $this->success("拿样成功！");
                        $tips['status']=1;//0为失败，1为成功
                        $tips['info']="拿样成功！";//错误信息
                        $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('portal/dslist/dslist_detail',array("id"=>$object_id));//跳转地址,发生错误不需要地址
                        $this->ajaxReturn($tips);
	        		}
	        		else{
	        			// $this->error("拿样成功,但信息发送失败，请联系服务商");
                        $tips['status']=0;//0为失败，1为成功
                        $tips['info']="拿样成功,但信息发送失败，请联系服务商";//错误信息
                        // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
                        $this->ajaxReturn($tips);
	        		}
	        		
	        	}
	        	else{
	        		// $this->error("拿样失败！");
                    $tips['status']=0;//0为失败，1为成功
                    $tips['info']="拿样失败！";//错误信息
                    // $tips['url'] = "http://".$_SERVER['HTTP_HOST'].U('user/login/index');//跳转地址,发生错误不需要地址
                    $this->ajaxReturn($tips);
	        	}
        	}
        }
    }
    
    //YHX20160515 发送拿样短信
    function send_sample_sms($feed_mobile,$contents){
    	//dump($feed_mobile);
    	//dump($contents);
    	//die();
        $username = "clymumo";
        $pwd = "hyx75tr8";
        $password = md5($username."".md5($pwd));
        $mobile = $feed_mobile;
        $content = $contents;
        $url = "http://sms-cly.cn/smsSend.do?";

        $param = http_build_query(
            array(
                'username'=>$username,
                'password'=>$password,
                'mobile'=>$mobile,
                'content'=>$content //YHX

            )
        );
//        dump($param);die();
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}


