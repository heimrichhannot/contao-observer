<?php

namespace HeimrichHannot\Observer;

class ObserverModel extends \Model
{

    protected static $strTable = 'tl_observer';

    /**
     * Find published observer by subject
     *
     * @param array $arrSubjects An array of types
     * @param array $arrOptions  An optional options array
     *
     * @return \ObserverModel|null The model or null if there are no observers
     */
    public static function findPublishedBySubjects(array $arrSubjects = [], array $arrOptions = [])
    {
        $t          = static::$strTable;
        $arrColumns = [];

        $time         = \Date::floorToMinute();
        $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";

        $arrColumns[] = \Database::getInstance()->findInSet('subject', $arrSubjects);

        if (!$arrOptions['order'])
        {
            $arrOptions['order'] = "$t.priority DESC";
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }

}