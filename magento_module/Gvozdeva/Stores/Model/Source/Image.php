<?php
class Gvozdeva_Stores_Model_Source_Image
{
    /**
     * Upload new store's image
     *
     * @return string
     */
    private function _uploadNewFile()
    {
        try {
            $path = Mage::getModel('stores/stores')->getImageDirectory();
            $uploader = new Varien_File_Uploader('image');
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png'])
                ->setAllowRenameFiles(true)
                ->setFilesDispersion(false)
                ->save($path, $_FILES['image']['name']);

            return Gvozdeva_Stores_Model_Stores::DIRECTORY_IMAGE . DS . $uploader->getUploadedFileName();
        } catch (Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
        }
    }

    /**
     * Delete, upload store's image
     *
     * @param array $image
     * @return string
     */
    public function processImage($image)
    {
        if (isset($image['delete'])) {
            $file = new Varien_Io_File();
            $file->rm(Mage::getBaseDir('media') . "/{$image['value']}");
            $image['value'] = '';
        }
        if ($_FILES['image']['name'] != '') {
            return $this->_uploadNewFile();
        } else {
            return $image['value'];
        }
    }
}
