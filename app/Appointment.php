<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Appointment extends Model
{
    protected $fillable = [
      'description',
      'specialty_id',
      'doctor_id',   //doctor
      'patient_id',
      'scheduled_date',
      'scheduled_time',
      'type'
    ];

    protected $hidden = [
      'specialty_id', 'doctor_id', 'scheduled_time'
    ];

    protected $appends = [
      'scheduled_time_12'
    ];

  /*  protected $dates = [  no procede para horas
      'scheduled_time'  //createFromFormat
    ];*/

    //  N $appointment -> specialty 1
    public function specialty(){
      return $this->belongsTo(Specialty::class);
    }

    //  N $appointment -> doctor 1
    public function doctor(){
      return $this->belongsTo(User::class);
    }

    //  N $appointment -> pacient 1
    public function patient(){
      return $this->belongsTo(User::class);
    }

    // Appointment hasOne 1 - 1/0 belongsTo CancelledAppointment
    //1  - 1/0  appointment->cancellation
    public function cancellation(){
      return $this->hasOne(CancelledAppointment::class);
    }

  //accesor
    public function getScheduledTime12Attribute(){
      return ( new Carbon($this->scheduled_time) )
            ->format('g:i A');
    }

    static public function createForPatient(Request $request, $patientId){
      $data = $request->only([
        'description',
        'specialty_id',
        'doctor_id',
        'scheduled_date',
        'scheduled_time',
        'type'
      ]);

      $data['patient_id'] = $patientId;
      //right time formato
      $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
      $data['scheduled_time'] = $carbonTime->format('H:i:s');

      return self::create($data);
    }
}
