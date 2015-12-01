<?php

namespace salic;

class SalicMng extends Salic
{
    private $mainEditTemplate = '@salic/backend.html.twig';

    /**
     * SalicMng constructor.
     */
    public function __construct()
    {
        $this->baseUrl = "/edit/";
        parent::__construct();
    }

    public function renderBackend()
    {
        $this->doRenderPage($this->mainEditTemplate, array(
            'pages' => $this->pages,
        ));
    }

    protected function doRenderPage($templatefile, $vars)
    {
        $vars['parent_template'] = $templatefile;
        parent::doRenderPage('@salic/edit.html.twig', $vars);
    }

    public function savePage($pagekey)
    {
        if (!array_key_exists('regions', $_POST)) {
            Utils::returnHttpError(400, "Error: missing regions in POST data");
        }
        $regions = $_POST['regions'];

        if (!array_key_exists($pagekey, $this->pages)) {
            //TODO: error handling
            Utils::returnHttpError(400, "Error: Unknown pagekey '$pagekey'");
        }

        $this->doSavePage($pagekey, $regions);
    }

    public function doSavePage($pagekey, array $regions)
    {
        foreach ($regions as $key => $val) {
            if (!is_dir("data/$pagekey/")) {
                if (!mkdir("data/$pagekey/", 0750, true)) { // rwxr-x---, TODO: configurable directory permissions
                    throw new \Exception("Failed to create directory 'data/$pagekey/'");
                }
            }

            $flag = file_put_contents("data/$pagekey/$key.txt", $val, LOCK_EX); // lock the file exclusively while writing
            if ($flag === false) {
                throw new \Exception("Failed to write file 'data/$pagekey/$key'");
            }
            //TODO: set file permissions
        }
    }

}

?>