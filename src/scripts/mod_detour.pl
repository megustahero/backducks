#!/usr/bin/perl
#!/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin -w

use warnings;
use strict;
use HTTP::Request;
use HTTP::Headers;
use LWP::UserAgent;
use JSON;

# in case you are dumb
if (@ARGV < 1) {
    print "Usage: $0 <create|update|delete> parcel_number type delivery_day\n";
    exit;
}

my $api_url = "127.0.0.1/api/";
my $url;

# read operation
if ($ARGV[0] eq "create") {
    $url = $api_url . "create.php";
} elsif ($ARGV[0] eq "delete") {
    (($ARGV[2] && $ARGV[3]) <= 0) ? ($url = $api_url . "delete.php") : (print "Invalid input, only parcel_number is required!\n");
} elsif ($ARGV[0] eq "udpate") {
    $url = $api_url . "update.php";
} else {
    print "Invalid operation!\n";
}

# debug
print $url . "\n";

my %json;
$json{parcel_number} = $ARGV[1];
$json{type} = $ARGV[2];
$json{delivery_day} = $ARGV[3];

# POST request body assembly
my $req = HTTP::Request->new( 'POST', $url );
$req->content_type('application/json');
$req->content( encode_json(\%json) );

# debug
print encode_json(\%json) . "\n";

# execute the request with LWP
my $lwp = LWP::UserAgent->new;
my $res = $lwp->request( $req );

# response print
if ($res->is_success) {
    my $message = $res->decoded_content;
    print "Received reply: $message \n";
}
else {
    print "HTTP POST error code: ", $res->code, "\n";
    print "HTTP POST error message: ", $res->message, "\n";
}

#my $ua = LWP::UserAgent->new(ssl_opts => { SSL_verify_mode => 'SSL_VERIFY_NONE' });

#sub command{
#    my($host, $target, $method, $header_ref, $data_ref) = @_;
#    my $data_json = %{$data_ref} ? encode_json($data_ref) : "";
#    my $request = HTTP::Request->new($method => 
#    "https://$host/$target", HTTP::Headers->new(%{$header_ref}), $data_json);
#    $request->header(Content_Type => 'application/json');
#    my $response = $ua->request($request);
#    return decode_json($response->content);
#}