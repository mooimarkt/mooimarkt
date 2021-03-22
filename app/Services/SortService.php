<?php

namespace App\Services;

class SortService
{
    public static function getNested($items)
    {
        $items = self::buildTree($items);
        $items = self::sortBySort($items);
        return $items;
    }

    public static function sortBySort($array)
    {
        $items = array();
        foreach ($array as $key => $row)
        {
            $items[$key] = $row['sort'];
        }
        array_multisort($items, SORT_ASC, $array);

        return $array;
    }

    public static function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public static function getOl($array, $child = FALSE)
    {
        $str = '';

        if (count($array))
        {
            $str .= $child == FALSE ? '<ol class="sortable">' : '<ol>';

            foreach($array as $item)
            {
                $str .= '<li id="list_' . $item['id'] . '" data-id="' . $item['id'] . '">';
                $str .= '<div>' . $item['name'] . '</div>';
                /*if ($item['name'] == 'Type') {
                    $str .= '<button type="submit" class="btn btn-edit-filter" disabled><i class="fa fa-pencil"></i></button>';
                    $str .= '<button type="submit" class="btn btn-delete-filter" disabled><i class="fa fa-trash-o"></i></button>';
                } else {
                    $str .= '<button type="submit" class="btn btn-edit-filter"><i class="fa fa-pencil"></i></button>';

                    $str .= '<button type="submit" class="btn btn-delete-filter" ><i class="fa fa-trash-o"></i></button>';
                }*/
                $str .= '<button type="submit" class="btn btn-edit-filter"><i class="fa fa-pencil"></i></button>';
                $str .= '<button type="submit" class="btn btn-delete-filter" ><i class="fa fa-trash-o"></i></button>';
                if (isset($item['children']) && count($item['children']))
                {
                    $str .= self::getOl($item['children'], TRUE);
                }
                $str .= '</li>' . PHP_EOL;
            }
            $str .= '</ol>' . PHP_EOL;
        }

        return $str;
    }


}