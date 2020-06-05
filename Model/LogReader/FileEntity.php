<?php
/**
 * Checkout.com
 * Authorized and regulated as an electronic money institution
 * by the UK Financial Conduct Authority (FCA) under number 900816.
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Checkout.com
 * @author    Platforms Development Team <platforms@checkout.com>
 * @copyright 2010-2019 Checkout.com
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://docs.checkout.com/
 */

namespace CheckoutCom\Magento2\Model\LogReader;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use CheckoutCom\Magento2\Api\Data\LogReader\LogEntityInterface;

class FileEntity extends AbstractModel implements FileEntityInterface, IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'file_entity';

    /**
     * @var string
     */
    public $_cacheTag = 'file_entity';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    public $_eventPrefix = 'file_entity';

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Naxero\Translation\Model\ResourceModel\FileEntity::class
        );
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::FILE_ID);
    }

    /**
     * Get is readable
     *
     * @return bool
     */
    public function getIsReadable()
    {
        return $this->getData(self::IS_READABLE);
    }

    /**
     * Get is writable
     *
     * @return bool
     */
    public function getIsWritable()
    {
        return $this->getData(self::IS_WRITABLE);
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->getData(self::FILE_PATH);
    }

    /**
     * Get file content
     *
     * @return string|null
     */
    public function getFileContent()
    {
        return $this->getData(self::FILE_CONTENT);
    }

    /**
     * Get rows count
     *
     * @return int|null
     */
    public function getRowsCount()
    {
        return $this->getData(self::ROWS_COUNT);
    }

    /**
     * Get file creation time
     *
     * @return string|null
     */
    public function getFileCreationTime()
    {
        return $this->getData(self::FILE_CREATION_TIME);
    }

    /**
     * Get file update time
     *
     * @return string|null
     */
    public function getFileUpdateTime()
    {
        return $this->getData(self::FILE_UPDATE_TIME);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setId($id)
    {
        return $this->setData(self::FILE_ID, $id);
    }

    /**
     * Set is readable
     *
     * @param bool $isReadable
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setIsReadable($isReadable)
    {
        return $this->setData(self::IS_READABLE, $isReadable);
    }

    /**
     * Set is writable
     *
     * @param bool $isWritable
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setIsWritable($isWritable)
    {
        return $this->setData(self::IS_WRITABLE, $isWritable);
    }

    /**
     * Set file path
     *
     * @param string $filePath
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFilePath($filePath)
    {
        return $this->setData(self::FILE_PATH, $filePath);
    }

    /**
     * Set file content
     *
     * @param string $content
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFileContent($fileContent)
    {
        return $this->setData(self::FILE_CONTENT, $fileContent);
    }

    /**
     * Set rows count
     *
     * @param string $rowsCount
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setRowsCount($rowsCount)
    {
        return $this->setData(self::ROWS_COUNT, $rowsCount);
    }

    /**
     * Set file creation time
     *
     * @param string $fileCreationTime
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFileCreationTime($fileCreationTime)
    {
        return $this->setData(self::FILE_CREATION_TIME, $fileCreationTime);
    }

    /**
     * Set update time
     *
     * @param string $fileUpdateTime
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFileUpdateTime($fileUpdateTime)
    {
        return $this->setData(self::FILE_UPDATE_TIME, $fileUpdateTime);
    }
}
