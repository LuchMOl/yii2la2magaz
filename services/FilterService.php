<?php

namespace app\services;

class FilterService
{

    public function rebuildAttackTypeGetParameter($filterListElement)
    {
        $getParamString = $this->getPageNumberString();
        $getParamString .= $this->buildGetParameterPart($filterGroup = 'attack-type', $filterListElement);

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
        $getParamString = $this->getPageNumberString();

        if ($_GET['attack-type']) {
            $getParamString .= '&attack-type=' . $_GET['attack-type'];
        }

        $getParamString .= $this->buildGetParameterPart($filterGroup = 'race', $filterListElement);

        if ($_GET['with-photo']) {
            $getParamString .= '&with-photo=' . $_GET['with-photo'];
        }

        return $getParamString;
    }

    public function rebuildPhotoGetParameter()
    {
        $getParamString = $this->getPageNumberString();

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

    public function getPageNumberString()
    {
        if ($_GET['page-number']) {
            $pageNumberSrting = 'page-number=' . $_GET['page-number'];
        } else {
            $pageNumberSrting = 'page-number=1';
        }
        return $pageNumberSrting;
    }

    public function buildGetParameterPart($filterGroup, $filterListElement)
    {
        if ($_GET[$filterGroup]) {

            $filterGroupArr = explode(',', $_GET[$filterGroup]);

            if (in_array($filterListElement, $filterGroupArr)) {

                $newFilterGroupArr = array_diff($filterGroupArr, [$filterListElement]);

                if ($newFilterGroupArr) {
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
