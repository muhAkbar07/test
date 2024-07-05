<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;
    protected $table = 'tickets';

    protected $casts = [
        'priority_id' => 'int',
        'unit_id' => 'int',
        'owner_id' => 'int',
        'problem_category_id' => 'int',
        'ticket_statuses_id' => 'int',
        'responsible_id' => 'int',
        'approved_at' => 'datetime',
        'solved_at' => 'datetime',
    ];

    protected $fillable = [
        'priority_id',
        'unit_id',
        'owner_id',
        'problem_category_id',
        'title',
        'asset_number',
        'serial_number',
        'outlet_id',
        'description',
        'ticket_statuses_id',
        'responsible_id',
        'approved_at',
        'solved_at',
    ];
    
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'approved_at',
        'solved_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::saving(function ($model) {
            $closeStatus = TicketStatus::where('name', 'Close')->first();
            $pendingStatus = TicketStatus::where('name', 'Pending')->first();
            $progressStatus = TicketStatus::where('name', 'Progress')->first();
    
            if ($model->isDirty('ticket_statuses_id')) {
                if ($closeStatus && $model->ticket_statuses_id == $closeStatus->id) {
                    $model->solved_at = Carbon::now();
                }
    
                if (($pendingStatus && $model->ticket_statuses_id == $pendingStatus->id) ||
                    ($progressStatus && $model->ticket_statuses_id == $progressStatus->id)) {
                    $model->approved_at = Carbon::now();
                }
            }
        });
    }
    

    /**
     * Get the priority that owns the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Check if SLA is breached for this ticket.
     *
     * @return bool
     */
    public function isSLABreached(): bool
    {
        $slaHours = $this->priority->sla_hours;
        $slaDeadline = $this->created_at->addHours($slaHours);
        $currentTime = now();

        return $currentTime > $slaDeadline && !$this->isHandled();
    }

    /**
     * Check if the ticket is handled.
     *
     * @return bool
     */
    public function isHandled(): bool
    {
        return $this->responsible_id !== null;
    }

    /**
     * Get the unit that owns the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the owner that owns the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the responsible that owns the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    /**
     * Get the problemCategory that owns the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function problemCategory()
    {
        return $this->belongsTo(ProblemCategory::class);
    }

    /**
     * Get the ticketStatus that owns the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_statuses_id');
    }

    /**
     * Get all of the comments for the Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'tiket_id');
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_statuses_id');
    }

    public function report()
    {
        return $this->belongsTo(TicketReport::class, 'report_id');
    }
}