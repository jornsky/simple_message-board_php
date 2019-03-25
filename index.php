<?php
//
header("conten-type:text/html;charset:utf-8");
date_default_timezone_set("PRC");

//检测文件是否存在
$filename = "msg.txt";
$msgs=[];
if(file_exists($filename)){                       //如果文件存在
    $string =  file_get_contents($filename);        //读取文件
    if(strlen($string)>0){                       //如果文件内容大于0
        $msgs = unserialize($string);
    }
}


//检测用户是否点击量提交按钮

if(isset($_POST['Publish'])){
    $username =$_POST['username'];
    $title =$_POST['title'];
    $content =$_POST['content'];

    $time = time();
    $data = compact('username','title','content','time');
    array_push($msgs,$data);
    $msgs = serialize($msgs);

    if(file_put_contents($filename,$msgs)){
        echo "<script>alert('留言成功！');location.href='index.php'; </script>";

    }
    else{
        echo "<script>alert('留言失败！');location.href='index.php'; </script>";

    }



}







?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>留言板</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/jquery-1.11.0.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1>留言板</h1>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (is_array($msgs) && count($msgs) >0 ): ?>
            <table class="table table-striped">
                <thead>
                        <tr class="active">
                                <th>编号</th>
                                <th>用户</th>
                                <th>时间</th>
                                <th>标题</th>
                                <th>内容</th>


                        </tr>

                </thead>

                <tbody>


                        <?php $i=1; foreach ($msgs as $val): ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['username']; ?>
                                        </td>
                                        <td>
                                            <?php echo date("m/d/Y H:i:s",$val['time']); ?>
                                        </td>
                                        <td>
                                            <?php echo $val['title']; ?>
                                        </td>
                                        <td>

                                            <?php echo $val['content']; ?>
                                        </td>


                                    </tr>
                        <?php endforeach; ?>




                </tbody>


            </table>

            <?php endif; ?>


        </div>
    </div>

    <hr/>

    <form method="post" action="#">
        <div class="form-group">
            <label >用户</label>
            <input type="text" class="form-control"  name="username" required="required">
        </div>
        <div class="form-group">
            <label >标题</label>
            <input type="text" class="form-control" name="title" required="required">
        </div>

        <div class="form-group">
            <label >内容</label>
            <textarea name="content" class="form-control" rows="5" cols="30" required="required">

            </textarea>
        </div>

        <button type="submit" class="btn btn-default btn-lg" name="Publish">提交</button>
    </form>

</div>

</body>
</html>