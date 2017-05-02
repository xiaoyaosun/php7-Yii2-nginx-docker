<?php

namespace api\components;

class Images
{
    var $inputName; //控件名
    var $allowType = array(
        'image/gif', 'image/jpg', 'image/jpeg', 'image/png', 'image/x-png', 'image/pjpeg'
    ); //上传类型
    var $allowSize = 2097152; //限制大小
    var $saveDir = "app-assets/contents/tmp/uploads/"; //保存目录
    var $isRename = true; //是否重命名，默认为true
    var $errID = 0; //错误代码，默认为0
    var $errMsg = ""; //错误信息
    var $savePath = ""; //保存路径
    var $extension = '.jpg';

    function __construct($inputName="image", $allowType = "", $allowSize = "", $saveDir = "", $isRename = true)
    {
        if (empty($inputName)) {
           // $this->chk_err(-1); //无传入控件名
        } else {
            $this->inputName = $inputName;
        }

        if (!empty($allowType)) $this->allowType = $allowType;
        if (!empty($allowSize)) $this->allowSize = $allowSize;
        if (!empty($saveDir)) $this->saveDir = $saveDir;
        $this->isRename = $isRename;
    }

    function is_uploaded()
    {
        if (empty($_FILES[$this->inputName]['name'])) {
            $this->chk_err(4); //没有文件被上传
        } else {
            if (is_uploaded_file($_FILES[$this->inputName]['tmp_name'])) {
                return true;
            } else {
                $this->chk_err(-2); //文件上传不合法
            }
        }
    }

    function chk_type()
    {
        if (!in_array($_FILES[$this->inputName]['type'], $this->allowType)) {
            $this->chk_err(-3); //上传的文件类型不被允许
        } else {
            return true;
        }
    }

    function chk_size()
    {
        if ($_FILES[$this->inputName]['size'] > $this->allowSize) {
            $this->chk_err(-4); //上传的文件过大
        } else {
            return true;
        }
    }

    function move_uploaded()
    { //移动上传文件
        if (!$this->is_uploaded()) {
            return false;
        }

        if (!$this->chk_size()) {
            return false;
        }

        if (!$this->chk_type()) {
            return false;
        }

        //重命名
        if ($this->isRename) {
            $arrTmp = pathinfo($_FILES[$this->inputName]['name']);

            $file_newname = uniqid() . $this->extension; //重命名新文件， 00表示为上传的为原图
        } else {
            $file_newname = $_FILES[$this->inputName]['name'];
        }

        if (!file_exists($this->saveDir)) { //判断保存目录是否存在
            mkdir($this->saveDir, 0777, true); //建立保存目录
        }

        //移动文件
        $result = move_uploaded_file($_FILES[$this->inputName]['tmp_name'], $this->saveDir . "/" . $file_newname);

        if ($result) {
            $path = $this->savePath = $this->saveDir . "/" . $file_newname; //文件的成功保存路径
            return $path;
        } else {
            $this->chk_err($_FILES[$this->inputName]['error']);
            return $this->get_errMsg();
        }
    }

    //判断出错信息
    function chk_err($errID)
    {
        $this->errID = $errID;
        switch ($this->errID) {
            case -4:
                $this->errMsg = "上传的文件过大";
                break;
            case -3:
                $this->errMsg = "上传的文件类型不被允许";
                break;
            case -2:
                $this->errMsg = "文件上传不合法";
                break;
            case -1:
                $this->errMsg = "无控件名传入";
                break;
            case 1:
                $this->errMsg = '上传的文件超出了php.ini中upload_max_filesize设定的最大值';
                break;
            case 2:
                $this->errMsg = '上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值';
                break;
            case 3:
                $this->errMsg = '文件只有部分被上传';
                break;
            case 4:
                $this->errMsg = '没有文件被上传';
                break;
            default:
                break;
        }
        return false;

    }

    function get_errMsg()
    {
        return $this->errMsg; //输出错误信息
    }

    /**
     * +----------------------------------------------------------
     * 取得图像信息
     *
     * +----------------------------------------------------------
     * @static
     * @access public
     * +----------------------------------------------------------
     * @param string $image 图像文件名
     * +----------------------------------------------------------
     * @return mixed
    +----------------------------------------------------------
     */
    function getImageInfo($img)
    {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime'],
            );
            return $info;
        } else {
            return false;
        }
    }

    /*
     * 生产最大 320*320图片
     */
    public function thumb320($image)
    {
        return $this->thumb($image, 320, 320);
    }


    /*
     * 生成最大 200*200的图片
     */
    public function thumb200($image)
    {
        return $this->thumb($image, 200, 200);
    }

    /*
    * 生成最大 100*100的图片
    */
    public function thumb100($image)
    {
        return $this->thumb($image, 100, 100);
    }

    /**
     * +----------------------------------------------------------
     * 生成缩略图
     * +----------------------------------------------------------
     * @static
     * @access public
     * +----------------------------------------------------------
     * @param string $image 原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth 宽度
     * @param string $maxHeight 高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     * @param boolean $is_save 是否保留原图
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */


    public function thumb($image, $maxWidth = 200, $maxHeight = 200, $is_save = true, $suofang = 0, $type = '', $interlace = true)
    {

        // 获取原图信息
        $info = $this->getImageInfo($image);

        if ($info !== false) {
            $srcWidth = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type) ? $info['type'] : $type;
            $type = strtolower($type);
            $interlace = $interlace ? 1 : 0;
            unset($info);
            if ($suofang == 1) {
                $width = $srcWidth;
                $height = $srcHeight;
            } else {
                $scale = max($maxWidth / $srcWidth, $maxHeight / $srcHeight); // 计算缩放比例
                if ($scale >= 1) {
                    // 超过原图大小不再缩略
                    $width = $srcWidth;
                    $height = $srcHeight;
                } else {
                    // 缩略图尺寸
                    $width = (int)($srcWidth * $scale); //147
                    $height = (int)($srcHeight * $scale); //199
                }
            }
            // 载入原图
            $createFun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

            $srcImg = $createFun($image);

            //创建缩略图
            if ($type != 'gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if (function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            if ('gif' == $type || 'png' == $type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color = imagecolorallocate($thumbImg, 0, 255, 0); //  指派一个绿色
                imagecolortransparent($thumbImg, $background_color); //  设置为透明色，若注释掉该行则输出绿色的图
            }
            // 对jpeg图形设置隔行扫描
            if ('jpg' == $type || 'jpeg' == $type) imageinterlace($thumbImg, $interlace);
            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image' . ($type == 'jpg' ? 'jpeg' : $type);
			
            $length = strlen("0." . $type) * (-1);
            $_type = substr($image, -4	);
            $length = ($type != $_type ? $length + 1 : $length);
            //裁剪
            if ($suofang == 1) {

                $thumbname01 = $image; //大头像
                $imageFun($thumbImg, $thumbname01, 100);

                $thumbImg01 = imagecreatetruecolor(100, 100);
                imagecopyresampled($thumbImg01, $thumbImg, 0, 0, $_POST['left'], $_POST['top'], 100, 100, $_POST['width'], $_POST['height']);

                $imageFun($thumbImg01, $thumbname01, 100);

                imagedestroy($thumbImg01);
                imagedestroy($thumbImg);
                imagedestroy($srcImg);

                return $thumbname01; //返回包含大小头像路径的数组
            } else {
                if ($is_save == false) { //缩略图覆盖原图，缩略图的路径还是原图路径

                    if ($type == 'png') {
						
						$imageFun($thumbImg, $image, 9);
                    } else {
                        $imageFun($thumbImg, $image, 100);
                    }
                } else {
                    $image_extension =  '-'.strval($maxWidth).'x'.strval($maxWidth).'.'.$type;

                    $thumbname03 = substr_replace($image, $image_extension, $length); 

					//缩略图与原图同时存在，
                    //缩略图的质量，0-100 （100最高）
					
					$imageFun($thumbImg, $thumbname03, 80);

                    imagedestroy($thumbImg);
                    imagedestroy($srcImg);
					
                    return $thumbname03; //返回缩略图的路径，字符串
                }
            }

        }
		
        return false;
    }
}
///***************
//	./uploads/2011/6/23/201106231015231234985800.jpg	----->上传到服务器上的原始图
//	./uploads/2011/6/23/201106231015231234985801.jpg	----->裁剪的大头像  190*195
//	./uploads/2011/6/23/201106231015231234985802.jpg	----->裁剪的小头像	48*48
//	./uploads/2011/6/23/201106231015231234985803.jpg	----->超过规定尺寸后的缩略图