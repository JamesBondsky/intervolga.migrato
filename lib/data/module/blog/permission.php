<?php
namespace Intervolga\Migrato\Data\Module\Blog;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Intervolga\Migrato\Data\BaseData;
use Intervolga\Migrato\Data\Record;
use Intervolga\Migrato\Data\RecordId;
use Intervolga\Migrato\Data\Link;
use Intervolga\Migrato\Tool\ExceptionText;

Loc::loadMessages(__FILE__);

class Permission extends BaseData
{
	protected function configure()
	{
		$this->setVirtualXmlId(true);
		Loader::includeModule("blog");
		$this->setEntityNameLoc(Loc::getMessage('INTERVOLGA_MIGRATO.BLOG_PERMISSION'));
		$this->setDependencies(array(
			'GROUP_ID' => new Link(Group::getInstance()),
			'BLOG_ID' => new Link(Blog::getInstance()),
		));
	}

	public function getList(array $filter = array())
	{

		$result = array();
		$permissions = \CBlogUserGroupPerms::getList();
		while ($permission = $permissions->fetch())
		{

			$id = $this->createId(array(
				"BLOG_ID" => $permission['BLOG_ID'],
				"GROUP_ID" => $permission['USER_GROUP_ID'],
			));
			$record = new Record($this);
			$record->setXmlId($this->getXmlId($id)); // тут ломается
			$record->setId($id);

			$record->addFieldsRaw(array(
				"PERMISSION" => $permission['PERMS'],
			));

			$dependency = $this->getDependency("GROUP_ID");
			$dependency->setValue(Group::getInstance()->getXmlId(RecordId::createNumericId($permission['USER_GROUP_ID'])));
			$record->setDependency("GROUP_ID", $dependency);

			$dependency = clone $this->getDependency("IBLOCK_ID");
			$dependency->setValue(Blog::getInstance()->getXmlId(RecordId::createNumericId($permission['BLOG_ID'])));
			$record->setDependency("BLOG_ID", $dependency);

			$result[] = $record;
		}


//		$getListGroups = \CBlogUserGroupPerms::getList();
//		$result = array();
//
//		while ($group = $getListGroups->fetch())
//		{
//			$record = new Record($this);
//			$id = $this->createId(array(
//				"BLOG_ID" => $group['BLOG_ID'],
//				"USER_GROUP_ID" => $group['USER_GROUP_ID'],
//			));
//			$record->setXmlId($this->getXmlId($id));
//			$record->setId($id);
//
//			$record->addFieldsRaw(array(
//				"BLOG_ID" => $group["BLOG_ID"], // должен зависесть от id блога
//				"USER_GROUP_ID" => $group["USER_GROUP_ID"],// должен зависесть от id группы
//				"PERMS_TYPE" => $group["PERMS_TYPE"],
//				"POST_ID" => $group["POST_ID"],
//				"PERMS" => $group["PERMS"],
//				"AUTOSET" => $group["AUTOSET"],
//			));
//
//			$result[] = $record;
//		}
//		return $result;
	}


	/**
	 * @return array|int[]
	 */
	protected function getBlogs()
	{
		$result = array();
		$getList = \CBlog::GetList();
		while ($blog = $getList->fetch())
		{
			$result[] = $blog["ID"];
		}

		return $result;
	}


//	public function getXmlId($id)
//	{
//		$array = $id->getValue();
//		$iblockData = Blog::getInstance();
//
////		$groupData = Group::getInstance();
////		$iblockXmlId = $iblockData->getXmlId($iblockData->createId($array['IBLOCK_ID']));
////		$groupXmlId = $groupData->getXmlId($groupData->createId($array['GROUP_ID']));
////		$md5 = md5(serialize(array(
////			$iblockXmlId,
////			$groupXmlId,
////		)));
////		return BaseXmlIdProvider::formatXmlId($md5);
//	}


//	public function update(Record $record)
//	{
//		$data = $this->recordToArray($record);
//		$id = $record->getId()->getValue();
//		global $strError;
//		$strError = '';
//		$result = \CBlogUserGroupPerms::update($id,$data);
//		if (!$result)
//		{
//			if ($strError)
//			{
//				throw new \Exception($strError);
//			} else
//			{
//				throw new \Exception(Loc::getMessage('INTERVOLGA_MIGRATO.BLOG_PERMISSION_UNKNOWN_ERROR'));
//			}
//		}
//	}

	/**
	 * @param Record $record
	 * @return array
	 */
//	protected function recordToArray(Record $record)
//	{
//		$array = array(
//
//		);
//
//		return $array;
//	}

//	protected function createInner(Record $record)
//	{
//		$data = $this->recordToArray($record);
//		global $strError;
//		$strError = '';
//		$result = \CBlogUserGroupPerms::add($data);
//		if ($result)
//		{
//			if (!$result->isSuccess())
//			{
//				throw new \Exception(ExceptionText::getFromResult($result));
//			}
//			else
//			{
//				return $this->createId($result->getId());
//			}
//		} else
//		{
//			if ($strError)
//			{
//				throw new \Exception($strError);
//			} else
//			{
//				throw new \Exception(Loc::getMessage('INTERVOLGA_MIGRATO.BLOG_PERMISSION_UNKNOWN_ERROR'));
//			}
//		}
//	}
//
//	protected function deleteInner(RecordId $id)
//	{
//		\CBlogUserGroupPerms::delete($id->getValue());
//	}
//
//	public function createId($id)
//	{
//		return RecordId::createComplexId(array(
//				"USER_GROUP_ID" => intval($id['USER_GROUP_ID']),
//				"GROUP_ID" => intval($id['GROUP_ID']),
//			)
//		);
//	}

}