<?php

namespace ModernMail\Mail\Traits;

use Illuminate\Notifications\Notification;
use ReflectionClass;
use ReflectionProperty;

trait InheritsProperties {

    public function inheritPropertiesFromNotification(Notification $notification) {
        $this->viewData = array_merge(collect(
        // add in public properties from the email
            (new ReflectionClass($notification))
                ->getProperties(ReflectionProperty::IS_PUBLIC)
        )
            // don't inherit properties from base classes
            ->filter(function(ReflectionProperty $property) use ($notification) {
                return $property->class === get_class($notification);
            })
            // map the properties to array format
            ->mapWithKeys(function(ReflectionProperty $property) use ($notification) {
                return [$property->getName() => $property->getValue($notification)];
            })
            ->all(), $this->viewData);
        return $this;
    }

    public function notifiable($notifiable) {
        $this->viewData['notifiable'] = $notifiable;
        return $this;
    }

}
