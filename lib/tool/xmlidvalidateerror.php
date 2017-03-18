<?namespace Intervolga\Migrato\Tool;

use Bitrix\Main\Localization\Loc;
use Intervolga\Migrato\Data\BaseData;
use Intervolga\Migrato\Data\RecordId;

Loc::loadMessages(__FILE__);

class XmlIdValidateError
{
	const TYPE_REPEAT = 1;
	const TYPE_EMPTY = 2;
	const TYPE_INVALID = 3;
	const TYPE_SIMPLE = 4;

	protected $dataClass;
	protected $type;
	protected $id;
	protected $xmlId;

	/**
	 * @param BaseData $dataClass
	 * @param int $type
	 * @param RecordId $id
	 * @param string $xmlId
	 */
	public function __construct(BaseData $dataClass, $type, $id, $xmlId)
	{
		$this->dataClass = $dataClass;
		$this->type = $type;
		$this->id = $id;
		$this->xmlId = $xmlId;
	}

	/**
	 * @return BaseData
	 */
	public function getDataClass()
	{
		return $this->dataClass;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getXmlId()
	{
		return $this->xmlId;
	}

	/**
	 * @return RecordId
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		$string = "";
		$name = "Validate error at " . $this->getDataClass()->getModule() . "/" . $this->getDataClass()->getEntityName();
		$xmlId = $this->getXmlId();
		if ($this->getType() == static::TYPE_EMPTY)
		{
			$string = $name . " " . $this->getId()->getValue() . " " . static::typeToString($this->getType());
		}
		if ($this->getType() == static::TYPE_REPEAT)
		{
			$string = $name . " " . $xmlId . " " . static::typeToString($this->getType());
		}
		if ($this->getType() == static::TYPE_INVALID)
		{
			$string = $name . " " . $xmlId . " " . static::typeToString($this->getType());
		}
		if ($this->getType() == static::TYPE_SIMPLE)
		{
			$string = $name . " " . $xmlId . " " . static::typeToString($this->getType());
		}

		return $string;
	}

	/**
	 * @param string $type
	 *
	 * @return string
	 */
	public static function typeToString($type)
	{
		if ($type == static::TYPE_EMPTY)
		{
			return Loc::getMessage("INTEVOLGA_MIGRATO.VALIDATE_ERROR_TYPE_EMPTY");
		}
		if ($type == static::TYPE_REPEAT)
		{
			return Loc::getMessage("INTEVOLGA_MIGRATO.VALIDATE_ERROR_TYPE_REPEAT");
		}
		if ($type == static::TYPE_INVALID)
		{
			return Loc::getMessage("INTEVOLGA_MIGRATO.VALIDATE_ERROR_TYPE_INVALID");
		}
		if ($type == static::TYPE_SIMPLE)
		{
			return Loc::getMessage("INTEVOLGA_MIGRATO.VALIDATE_ERROR_TYPE_SIMPLE");
		}
		return Loc::getMessage("INTEVOLGA_MIGRATO.VALIDATE_ERROR_TYPE_UNKNOWN");
	}
}