<?php namespace Anomaly\MultipleFieldType\Http\Controller;

use Anomaly\MultipleFieldType\Command\GetConfiguration;
use Anomaly\MultipleFieldType\Command\HydrateLookupTable;
use Anomaly\MultipleFieldType\Command\HydrateValueTable;
use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\MultipleFieldType\Table\LookupTableBuilder;
use Anomaly\MultipleFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class LookupController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType\Http\Controller
 */
class LookupController extends AdminController
{

    /**
     * Return an index of entries from related stream.
     *
     * @param LookupTableBuilder $table
     * @param                    $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(LookupTableBuilder $table, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $table
            ->setConfig($config)
            ->setModel($config->get('related'));

        $this->dispatch(new HydrateLookupTable($table));

        return $table->render();
    }

    /**
     * @param Container         $container
     * @param MultipleFieldType $fieldType
     * @param                   $key
     */
    public function json(Container $container, MultipleFieldType $fieldType, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $fieldType->mergeConfig($config->all());

        /* @var EloquentModel $model */
        $model = $container->make($config->get('related'));

        $data = [];

        /* @var EntryInterface $item */
        foreach ($model->all() as $item) {
            $data[] = (object)[
                'id'   => $item->getId(),
                'text' => $item->getTitle()
            ];
        }

        return $this->response->json($data);
    }

    /**
     * Return the selected entries.
     *
     * @param ValueTableBuilder $table
     * @param                   $key
     * @return null|string
     */
    public function selected(ValueTableBuilder $table, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $table
            ->setConfig($config)
            ->setModel($config->get('related'))
            ->setSelected(explode(',', $this->request->get('uploaded')));

        $this->dispatch(new HydrateValueTable($table));

        return $table->build()->response()->getTableContent();
    }
}
