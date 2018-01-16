<?php namespace App\Handlers\Events;

use AmoCRM\Client as AMO;
use App\Events\ClaimCreate;
use Log;
use App\Property;

class ClaimToAmo
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function handle(ClaimCreate $event)
    {
        $claim = $event->claim;


        try {


            if ( !in_array($claim->project_id, array(128,130,133)) ) return true;

            if ($claim->project_id == 128 && $claim->type_request != 361) return true;
            if ($claim->project_id == 130 && $claim->type_request != 369) return true;
            if ($claim->project_id == 133 && $claim->type_request != 373) return true;

            $properties = Property::showPropertyValue($claim);

            $model = null;
            $color = null;

            foreach ($properties as $key => $property) {
                if ($key === 127 && $property['value']!="Общая инфрмация") {
                    $model = $property['value'];
                }

                if ($key === 129) {
                    $color = $property['value'];
                }
            }


            $amo = new AMO(env('AMO_HOST'), env('AMO_LOGIN'), env('AMO_API_KEY'));


            // Получение экземпляра модели для работы с контактами
            $lead = $amo->lead;
            //Заполнение полей модели
            $lead['name'] = "Заявка в call-№1";

            $lead->addCustomField(144969, config('app.url').'/claim/' . $claim->id);
            $lead->addCustomField(145597,$claim->text);


            if(!empty($model)){
                $lead->addCustomMultiField(145047, [config('amoconf.products')[ $model ]]);
            }

            if(!empty($color)) {
                $lead->addCustomMultiField(145063, [config('amoconf.colors')[ $color ]]);
            }


            $lead_id = $lead->apiAdd();

            $contact = $amo->contact;

            $contact['name'] = $claim->name;
            $contact['linked_leads_id'] = $lead_id;
            $contact->addCustomField(87299, $claim->phone, 'MOB');
            $contact_id = $contact->apiAdd();

            \Log::alert('Создал заявку', array('$contact_id' => $contact_id));

        } catch (\Exception $e) {
            \Log::error('Ошибка при создании заявки и отправлении в AMO', array('error' => $e->getMessage()));
        }

        return true;
    }
}