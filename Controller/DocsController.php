<?php
/**
 * DefaultController.php
 *
 * @copyright (c) 2013 The Nerdery
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Nerdery\DocumentationBundle\Controller;

use JMS\AopBundle\Exception\RuntimeException;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

use Nerdery\DocumentationBundle\Router\FileNotFoundException;
use Nerdery\DocumentationBundle\Router\PackageRouter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Docs Controller
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@Nerdery.com>
 */
class DocsController extends Controller
{
    /**
     * View Action
     *
     * Used to view a specific markdown documentation page.
     *
     * @Route(
     *     "/{path}",
     *     name="_nerdery_documentation_view",
     *     requirements={"path" = ".+"}
     * )
     * @Template
     * @param string $path The path of the documentation to get in format:
     *     `/PACKAGE/path/to/file.md`
     * @return RedirectResponse|array
     */
    public function viewAction($path)
    {
        $router = $this->getDocumentationRouter();
        $parser = $this->getParser();

        try {
            $path = $router->getDocument($path);
            $contents = file_get_contents($path);
            $html = $parser->transformMarkdown($contents);

            return array('html' => $html);
        } catch (FileNotFoundException $fileNotFoundException) {

            return $this->attemptRecovery($fileNotFoundException);
        }
    }

    /**
     * Attempt Recovery
     *
     * Attempts to recover the response with a redirect to the correct index
     * file if available.
     *
     * @param FileNotFoundException $fileNotFoundException The problematic
     *     exeption
     * @return \Symfony\Component\HttpFoundation\RedirectResponse A redirect
     *     response to the correct controller
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *     When No recovery could be made.
     */
    protected function attemptRecovery(FileNotFoundException $fileNotFoundException)
    {
        if (false === $fileNotFoundException->isRecoverable()) {
            throw new NotFoundHttpException($fileNotFoundException->getMessage());
        }

        $url = $this->generateUrl(
            '_nerdery_documentation_view',
            array('path' => $fileNotFoundException->getRecoverFile())
        );
        return $this->redirect($url);
    }

    /**
     * @return PackageRouter
     */
    private function getDocumentationRouter()
    {
        $loader = $this->get('nerdery_documentation.package_router');

        return $loader;
    }

    /**
     * Get Parser
     *
     * Fetches the Markdown parser service from the DI container
     *
     * @return MarkdownParserInterface
     */
    private function getParser()
    {
        $parser = $this->get('markdown.parser');

        return $parser;
    }
}
