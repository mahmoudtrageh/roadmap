<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StreakAchievementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected int $currentStreak,
        protected int $milestone
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Congratulations! {$this->milestone} Day Streak!")
            ->greeting("Amazing Achievement!")
            ->line("You've reached a {$this->milestone} day streak!")
            ->line("Your current streak is {$this->currentStreak} days.")
            ->line("Keep up the great work and continue your learning journey!")
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you for being consistent with your learning!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'streak_achievement',
            'current_streak' => $this->currentStreak,
            'milestone' => $this->milestone,
            'message' => "Congratulations! You've reached a {$this->milestone} day streak!",
        ];
    }
}
