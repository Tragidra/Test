<?php
class Graph {

    public static function count($pathList, $start, $end, $visited = [], $path = []): array
    {
        global $a;
        static $result = [];
        $visited[$start] = true;
        $path[] = $start;

        if ($start == $end){
            $a[] = implode(',', $path) . '<br>';
            $result[] = $path;
        }else{
            foreach ($pathList[$start] AS $point){
                if (!$visited[$point]){
                    self::count($pathList, $point, $end, $visited, $path);
                }
            }
        }
        array_pop($path);
        $visited[$start] = false;

        return $result;
    }

    public static function neighboring($pathList): array
    {
        $pathInfo = [];
        foreach ($pathList AS $list){
            foreach ($list AS $value){
                $k = array_search($value, $list);
                isset($list[$k - 1]) && $pathInfo[$value][] = $list[$k - 1];
                isset($list[$k + 1]) && $pathInfo[$value][] = $list[$k + 1];
            }
        }
        foreach ($pathInfo AS $key => $list){
            $pathInfo[$key] = array_unique($list);
        }
        return $pathInfo;
    }
}
