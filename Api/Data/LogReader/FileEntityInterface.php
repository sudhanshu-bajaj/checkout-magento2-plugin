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

namespace CheckoutCom\Magento2\Api\Data\LogReader;

interface FileEntityInterface
{
    /**
     * Constants for keys of data array.
     */
    const FILE_ID = 'file_id';
    const IS_READABLE = 'is_readable';
    const IS_WRITABLE = 'is_writable';
    const FILE_PATH = 'file_path';
    const FILE_CONTENT = 'file_content';
    const ROWS_COUNT = 'rows_count';
    const FILE_CREATION_TIME = 'file_creation_time';
    const FILE_UPDATE_TIME = 'file_update_time';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get is readable
     *
     * @return bool
     */
    public function getIsReadable();

    /**
     * Get is writable
     *
     * @return bool
     */
    public function getIsWritable();

    /**
     * Get file path
     *
     * @return string
     */
    public function getFilePath();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getFileContent();

    /**
     * Get rows count
     *
     * @return int|null
     */
    public function getRowsCount();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getFileCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getFileUpdateTime();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setId($id);

    /**
     * Set is readable
     *
     * @param string $filePath
     * @return bool
     */
    public function setIsReadable($filePath);

    /**
     * Set is writable
     *
     * @param string $filePath
     * @return bool
     */
    public function setIsWritable($filePath);

    /**
     * Set file path
     *
     * @param string $filePath
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFilePath($filePath);

    /**
     * Set file content
     *
     * @param string $fileContent
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFileContent($fileContent);

    /**
     * Set rows count
     *
     * @param string $rowsCount
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setRowsCount($rowsCount);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFileCreationTime($fileCreationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \Naxero\Translation\Api\Data\FileEntityInterface
     */
    public function setFileUpdateTime($fileUpdateTime);
}