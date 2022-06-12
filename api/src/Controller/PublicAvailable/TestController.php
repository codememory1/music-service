<?php

namespace App\Controller\PublicAvailable;

use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  codememory
 */
class TestController extends AbstractRestController
{
    #[Route('/test')]
    public function red(): JsonResponse
    {
        ?>
        <script>
            const ws = new WebSocket('ws://127.0.0.1/ws');

            setTimeout(() => {
               ws.send(JSON.stringify({
                   headers: {
                       access_token: null,
                       refresh_token: null
                   },
                   data: {
                       type: null,
                       message: null
                   }
               }));
            }, 2000);
        </script>
        <?php

        return new JsonResponse(123);
    }
}