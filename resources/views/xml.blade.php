@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<request type="schedule-new" timestamp="{{ $data['date'] }}">
    <merchantid>beforemx</merchantid>
    <account>internet</account>
    <channel>ECOM</channel>
    <scheduleref>{{ $data['ref_elavon'] }}_schedu</scheduleref>
    <transtype>auth</transtype>
    <schedule>monthly</schedule>
    <numtimes>{{ $data['Period'] }}</numtimes>
    <payerref>{{ $data['ref_elavon'] }}</payerref>
    <paymentmethod>{{ $data['ref_elavon'] }}_card</paymentmethod>
    <amount currency="EUR">{{ round(floatval($data['summ']) * 100) }}</amount>
    <sha1hash>@php echo sha1(sha1($data['date'].'.beforemx.'.$data['ref_elavon'].'_schedu.'.round(floatval($data['summ']) * 100).'.EUR.'.$data['ref_elavon'].'.monthly').'.gjW2s8lWLe'); @endphp</sha1hash>
</request>