<?php

namespace app\services;

const TITLE_RACE_GET_GROUP = 'race';
const TITLE_ATTACK_TYPE_GET_GROUP = 'attack-type';
const FIRST_PEGE = 'page-number=1';

class FilterService
{

    public function rebuildAttackTypeGetParameter($filterListElement)
    {
        $getParamString = FIRST_PEGE;
        $getParamString .= $this->buildFilterGroupString(TITLE_ATTACK_TYPE_GET_GROUP, $filterListElement);

        if ($_GET[TITLE_RACE_GET_GROUP]) {
            $getParamString .= '&' . TITLE_RACE_GET_GROUP . '=' . $_GET[TITLE_RACE_GET_GROUP];
        }

        if ($_GET['with-photo']) {
            $getParamString .= '&with-photo=' . $_GET['with-photo'];
        }

        return $getParamString;
    }

    public function rebuildRaceGetParameter($filterListElement)
    {
        $getParamString = FIRST_PEGE;

        if ($filterListElement == 'без рассы') {
            $filterListElement = 'no-race';
        }

        if ($_GET[TITLE_ATTACK_TYPE_GET_GROUP]) {
            $getParamString .= '&' . TITLE_ATTACK_TYPE_GET_GROUP . '=' . $_GET[TITLE_ATTACK_TYPE_GET_GROUP];
        }

        $getParamString .= $this->buildFilterGroupString(TITLE_RACE_GET_GROUP, $filterListElement);

        if ($_GET['with-photo']) {
            $getParamString .= '&with-photo=' . $_GET['with-photo'];
        }

        return $getParamString;
    }

    public function rebuildPhotoGetParameter()
    {
        $getParamString = FIRST_PEGE;

        if ($_GET[TITLE_ATTACK_TYPE_GET_GROUP]) {
            $getParamString .= '&' . TITLE_ATTACK_TYPE_GET_GROUP . '=' . $_GET[TITLE_ATTACK_TYPE_GET_GROUP];
        }

        if ($_GET[TITLE_RACE_GET_GROUP]) {
            $getParamString .= '&' . TITLE_RACE_GET_GROUP . '=' . $_GET[TITLE_RACE_GET_GROUP];
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
        if ($filterElement == 'без рассы') {
            $filterElement = 'no-race';
        }

        if (in_array($filterElement, $currentFilterListArray)) {
            $checked = 'checked';
        } else {
            $checked = '';
        }

        return $checked;
    }

}
