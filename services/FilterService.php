<?php

namespace app\services;

class FilterService
{

    public function rebuildAttackTypeGetParameter($filterListElement)
    {
        $getParamString = 'page-number=1';
        $getParamString .= $this->buildFilterGroupString($filterGroup = 'attack-type', $filterListElement);

        if ($_GET['race']) {
            $getParamString .= '&race=' . $_GET['race'];
        }

        if ($_GET['with-photo']) {
            $getParamString .= '&with-photo=' . $_GET['with-photo'];
        }

        return $getParamString;
    }

    public function rebuildRaceGetParameter($filterListElement)
    {
        $getParamString = 'page-number=1';

        if ($_GET['attack-type']) {
            $getParamString .= '&attack-type=' . $_GET['attack-type'];
        }

        $getParamString .= $this->buildFilterGroupString($filterGroup = 'race', $filterListElement);

        if ($_GET['with-photo']) {
            $getParamString .= '&with-photo=' . $_GET['with-photo'];
        }

        return $getParamString;
    }

    public function rebuildPhotoGetParameter()
    {
        $getParamString = 'page-number=1';

        if ($_GET['attack-type']) {
            $getParamString .= '&attack-type=' . $_GET['attack-type'];
        }

        if ($_GET['race']) {
            $getParamString .= '&race=' . $_GET['race'];
        }

        if (!$_GET['with-photo']) {
            $getParamString .= '&with-photo=1';
        }

        return $getParamString;
    }

    public function buildFilterGroupString($filterGroup, $filterListElement)
    {
        if ($_GET[$filterGroup]) {

            $filterGroupArr = explode(',', $_GET[$filterGroup]);

            if (in_array($filterListElement, $filterGroupArr)) {

                $newFilterGroupArr = array_diff($filterGroupArr, [$filterListElement]);

                if (!empty($newFilterGroupArr)) {
                    $filterGroupString = '&' . $filterGroup . '=' . implode(",", $newFilterGroupArr);
                }
            } else {
                $filterGroupString = '&' . $filterGroup . '=' . implode(",", $filterGroupArr) . ',' . $filterListElement;
            }
        } else {
            $filterGroupString = '&' . $filterGroup . '=' . $filterListElement;
        }
        return $filterGroupString;
    }

    public function checked($filterElement, $currentFilterListArray)
    {
        if (in_array($filterElement, $currentFilterListArray)) {
            $checked = 'checked';
        } else {
            $checked = '';
        }

        return $checked;
    }

}
