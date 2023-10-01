<x-mail::message>
<h1>Welcome to Mero Hostel</h1>

Hello {{ $user->name }},

We're excited to have you on board! Please take a moment to verify your
email address to complete your registration and get started with Mero Hostel.

<p><strong>Email Address:</strong> {{ $user->email }}</p>

<x-mail::button :url="$url">
    Verify Mail
</x-mail::button>



By verifying your email, you'll gain access to all the features and benefits of Mero Hostel, including:
<ul>
    <li>Booking rooms and accommodations with ease</li>
    <li>Accessing exclusive discounts and promotions</li>
    <li>Receiving important updates and notifications</li>
</ul>

<p>If you have any questions or need assistance, feel free to contact our support team at support@merohostel.com.</p>

<p>Thank you for choosing Mero Hostel!</p>

<p>Best regards,<br>Mero Hostel</p>
</x-mail::message>
