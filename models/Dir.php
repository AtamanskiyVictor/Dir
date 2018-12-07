<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

/**
 * ContactForm is the model behind the contact form.
 */
class Dir extends Model
{
    private $strPath;
    private $intId;

    public function __construct($strPath)
    {
        parent::__construct();
        $this->setPath($strPath);
    }

    /**
     * Main recursion function
     * @param string $path the input path.
     * @param int $parentId Id of parent dir.
     * @return array the full path all files & dir in path.
     */
    private function getDir($path, $parentId)
    {
        $arDir = [];
        if (!is_dir($path)) return $arDir;

        foreach (array_diff (scandir($path) , [".",".."]) as $value) {
            $strFullPath = $path ."/". $value;

            $this->intId++;
            $row = [
                'id'=>$this->intId,
                'parentId'=>$parentId,
                'name'=>$value,
                'path'=>$strFullPath,
                'title'=>'<a href="' . Url::to(['dir/index', 'path' => $strFullPath])
                    . "\" target='_blank'>".$value."</a>",
            ];

            if (is_dir ($strFullPath) ) {
                /*$arDir = array_merge ($this->getDir ($strFullPath, $this->intId), $arDir);
                array_unshift($arDir, $row);
                */
                $arDir[] = $row + [
                    'folder'=>'true', 'children'=>$this->getDir ($strFullPath, $this->intId)];
            } else {
                $arDir[] = $row;
            }
        }
        return $arDir;
    }

    /**
     * Set $this->strPath
     * @param string $path the root path.
     */
    public function setPath($path)
    {
        $this->strPath = file_exists($path) ? $path : "." ;
    }


    /**
     * @return array the full path all files & dir's in $this->strPath.
     */
    public function getDirAllAr()
    {
        $this->intId = 1;

		$data = Yii::$app->cache->getOrSet($this->strPath, function () {
            return $this->getDir($this->strPath, 1);
    	},15);

        return $data;
    }

    /**
     * @return array info of $this->strPath.
     */
    public function getDirInfo()
    {
        $arDirInfo[0] = $strPath = $this->strPath;
        if($strPath != ".") {
            $arDirInfo[1] = is_dir($strPath);
            $arDirInfo[2] = stat($strPath);
        }
        return $arDirInfo;
    }

}
