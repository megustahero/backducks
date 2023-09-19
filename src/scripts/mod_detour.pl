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

    my $api_url = "http://127.0.0.1/api/";
    my $url;
    my %json;

    # read operation
    if ($ARGV[0] eq "create") {
        $url = $api_url . "create.php";
        $json{parcel_number} = $ARGV[1];
        $json{type} = $ARGV[2];
        $json{delivery_day} = $ARGV[3];
    } elsif ($ARGV[0] eq "delete") {
        # Tried to handle invalid input, but not necessary for now
        # ((length($ARGV[2]) lt 0) && (length($ARGV[3]) lt 0)) ? ($url = $api_url . "delete.php") : (print "Invalid input, only parcel_number is required!\n");
        $url = $api_url . "delete.php";
        $json{parcel_number} = $ARGV[1];
    } elsif ($ARGV[0] eq "udpate") {
        $url = $api_url . "update.php";
        $json{parcel_number} = $ARGV[1];
        $json{type} = $ARGV[2];
        $json{delivery_day} = $ARGV[3];
    } else {
        print "Invalid operation!\n";
    }

    # debug
    print "API endpoint: " . $url . "\n";

    # POST request body assembly
    my $req = HTTP::Request->new( 'POST', $url );
    $req->content_type('application/json');
    $req->content( encode_json(\%json) );

    # debug
    print "Sent JSON object: " . encode_json(\%json) . "\n";

    # execute the request with LWP
    my $lwp = LWP::UserAgent->new;
    my $res = $lwp->request( $req );

    # response print
    if ($res->is_success) {
        print "HTTP POST success code: ", $res->code, "\n";
        print "HTTP POST success message: ", $res->message, "\n";
        print "Received API reply: ", $res->decoded_content, "\n";
    }
    else {
        print "HTTP POST error code: ", $res->code, "\n";
        print "HTTP POST error message: ", $res->message, "\n";
    }