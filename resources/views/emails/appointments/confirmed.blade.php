<p>Hi {{ $appointment->name }},</p>

<p>Your appointment has been <strong>confirmed</strong> 🎉</p>

<p>
    <strong>Type:</strong> {{ ucfirst($appointment->type->value) }} <br>
    <strong>Date:</strong> {{ $appointment->date }} <br>
    <strong>Time:</strong> {{ $appointment->start }} - {{ $appointment->end }}
</p>

<p>We look forward to seeing you!</p>

<p>Regards,<br>Missionaries of Charity Brothers</p>
