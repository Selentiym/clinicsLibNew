<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.09.2016
 * Time: 21:32
 */
/**
 * array (size=14)
'дата' => string '1.09' (length=4)
'типисследования' => string 'мрт гм' (length=11)
'н' => string '' (length=0)
'пожеланияклиента' => string '' (length=0)
'фио' => string 'Леготина Екатерина Николаевна' (length=56)
'датарождения' => string '' (length=0)
'контактныйтелефон' => string '' (length=0)
'клиника' => string '' (length=0)
'цена' => string '' (length=0)
'отчетпозвонку' => string 'записаны, не у нас' (length=32)
'mangotalkerномер' => string '79121212660' (length=11)
'комментарий' => string 'заявка' (length=12)
'направление' => string '' (length=0)
'sa' => string '' (length=0)
 */
//class GDCall extends Call{
class GDCall extends aGDCall{
    public $entry;
    public $year;
    private $_callTime;

    const DATESTRING_KEY="Дата";

    const verified = 'verified';
    const missed = 'missed';
    const cancelled = 'cancelled';
    const side = 'side';
    const declined = 'declined';
    const assigned = 'assigned';

    /**
     * @param \Google\Spreadsheet\ListEntry $entry
     * @param aGDCallFactory $factory
     * @throws GoogleDocApiException
     * Since this class is descendant to CActiveRecord, __construct must not be used.
     * I don't believe in the CActiveRecord::init() either, so I created my own initialize method,
     * which will be used by all the factories
     */
    public function initialize(Google\Spreadsheet\ListEntry $entry, aGDCallFactory $factory) {
        parent::initialize($entry, $factory);
        if (!is_a($factory, 'SimpleGDFactory')) {
            throw new GoogleDocApiException('Invalid factory for '.get_class($this));
        }
        /**
         * @type SimpleGDFactory $factory
         */
        $data = $this -> _data;

        $this -> year = $factory -> getYear();
        $this -> entry = $entry;
        $this -> State = $data["sa"];
        $this -> report = $data["отчетпозвонку"];
        $this -> research_type = $data["типисследования"];
        //$this -> i = $array[2];
        $dataH = trim($data["н"]);
        //echo $data;
        if (preg_match('/id\d+/',$dataH)) {
            $this -> i = str_replace("id","",$dataH);
            $this -> IFromFile = true;
            //echo "i";
        } elseif (preg_match('/^\d+$/',$dataH)) {
            $this -> j = $dataH;
            //echo "j";
        } elseif (is_string($dataH)) {
            $this -> H = $dataH;
            //echo "H";
        }
        //$this -> j = $array[3];
        //$this -> H = $array[4];
        $this -> fio = $data["фио"];
        $this -> wishes = $data["пожеланияклиента"];
        $this -> birth = $data["датарождения"];
        $this -> number = $data["контактныйтелефон"];
        $this -> clinic = $data["клиника"];
        $this -> price = $data["цена"];
        $this -> mangoTalker = $data["mangotalkerномер"];
        $this -> comment = $data["комментарий"];
    }
    public function getYear() {
        if (!$this -> year) {
            $this -> year = $this -> getFactory() -> getYear();
        }
        return $this -> year;
    }

    /**
     * @param aGDCall $gdCall
     * @return bool whether these two objects correspond to the same call
     */
    public function compareWith(aGDCall $gdCall) {
        if (get_class($gdCall) != get_class($this)) {
            return false;
        }
        /**
         * @type self $gdCall
         */
         return $this -> countDiff($gdCall) == 0;
    }

    /**
     * @param self $gdCall
     * @return integer
     */
    protected function countDiff(self $gdCall) {
        $diffs = 0;
        if (date('j.n',strtotime($this -> getCallTime()))!= date('j.n',strtotime($gdCall -> getCallTime()))) {
            $diffs ++;
        }
        if ($this -> fio != $gdCall -> fio) {
            $diffs ++;
        }
        return $diffs;
    }

    /**
     * @return string the telephone number
     */
    public function getNumber() {
        return $this -> mangoTalker;
    }
    /**
     * @return integer
     */
    public function getCallTime(){
        if (!$this -> _callTime) {
            $this -> _callTime = strtotime("12:00:00 ".$this->_data[self::DATESTRING_KEY] . '.' . $this->getYear());
        }
        return $this -> _callTime;
    }
    /**
     * @return integer - the type of call.
     */
    public function getStatus(){
        return callStatusHelper::standardProcedure($this -> report, $this -> State);
    }
}
?>
