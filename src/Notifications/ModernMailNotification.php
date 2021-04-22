<?php
namespace ModernMail\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use ModernMail\Notifications\Channels\ModernMailChannel;

class ModernMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public static function preview($notifiable = null) {
        $className = static::class;
        if (empty($notifiable)) {
            /** @var User $notifiable */
            $notifiable = factory(User::class)->create();
        }
        $arguments = [];
        if (method_exists($className, 'seed')) {
            $arguments = $className::seed();
        }
        $instance = (new static(...$arguments));
        return app(ModernMailChannel::class)->preview($notifiable, $instance);
    }
}
