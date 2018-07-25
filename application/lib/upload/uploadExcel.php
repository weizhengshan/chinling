<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 下午 13:32
 */
namespace  app\lib\upload;

class UploadExcel
{
    public static function UploadFile($file,$SecondField)
    {
        // 获取表单提交过来的文件
        //$textName=$_FILES['file']['name'];
        $error = $_FILES['file']['error'];  // 如果$_FILES['file']['error']>0,表示文件上传失败
        if(!$error){
            $dir = ROOT_PATH . 'public' . DS . 'upload';
            // 验证文件并移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>3145728,'ext'=>'xls,xlsx,csv'])->rule('uniqid')->move($dir);
            /*判断是否符合验证*/
            if($info){    //  符合类型
                $extension = $info->getExtension();
                $filename = $dir. DS .$info->getSaveName();
                //echo $filename;
                Vendor("PHPExcel.IOFactory");
                if ($extension =='xlsx') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel2007");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension =='xls') {
                    $reader = \PHPExcel_IOFactory::createReader("Excel5");
                    $PHPExcel = $reader ->load($filename);
                } else if ($extension=='csv') {
                    $reader = \PHPExcel_IOFactory::createReader("CSV");
                    //默认输入字符集
                    $reader->setInputEncoding('GBK');
                    //默认的分隔符
                    $reader->setDelimiter(',');
                    //载入文件
                    $PHPExcel = $reader->load($filename);
                }
                $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $highestColumm = $sheet->getHighestColumn(); // 取得总列数
                //判断上传是否为订单数据
                $number=1;
                $is_order = $sheet->getCell('B' . $number)->getValue();
                if($is_order != $SecondField)
                {
                    return ['valid'=>1,'msg'=>'不是指定文件'];
                    exit;
                }
                $data=array(
                    'highestRow'=>$highestRow,
                    'sheet'=>$sheet
                );
                return  ['valid'=>4,'data'=>$data];
            }
        } else{ //  不符合类型业务
            return ['valid'=>1,'msg'=>'请选择上传3MB内的excel表格文件...'];
            //$this->error('请选择上传3MB内的excel表格文件...');
            //echo $file->getError();
        }

    }

}