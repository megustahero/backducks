#!/usr/bin/perl
#!/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin -w
use strict;
use warnings;
use HTTP::Request;
use HTTP::Headers;
use LWP::UserAgent;
use JSON;

    # Define API URL
    my $api_url = "http://127.0.0.1/api/";

    # Check for correct number of arguments
    if (@ARGV < 4 || @ARGV > 5) {
        die "Usage: $0 <create|update|delete> parcel_number type delivery_day [id] [debug]\n";
    }

    # Read operation and assemble URL, JSON data, and HTTP method
    my ($operation, $parcel_number, $type, $delivery_day, $id, $debug) = @ARGV;

    # Validate parcel_number
    if ($parcel_number !~ /^\d{14}$/) {
        die "Error: parcel_number must be a 14-digit number.\n";
    }

    # Validate type
    if ($type !~ /^\d+$/) {
        die "Error: type must be a numeric value.\n";
    }

    # Validate delivery_day
    if ($delivery_day !~ /^\d{4}-\d{2}-\d{2}$/) {
        die "Error: delivery_day must be in YYYY-MM-DD format.\n";
    }

    my %json = (
        parcel_number => $parcel_number,
        type          => $type,
        delivery_day  => $delivery_day
    );

    if ($operation eq "update") {
        $json{id} = $id if defined $id;
    }

    my %methods = (
        create => 'POST',
        update => 'PUT',
        delete => 'DELETE'
    );

    my $url = $api_url . "$operation.php";
    my $method = $methods{$operation};

    # Debug information
    if ($debug && $debug eq "debug") { 
        print "API endpoint: $url\n";
        print "Sent JSON object: " . encode_json(\%json) . "\n";
    }

    # Create HTTP request
    my $req = HTTP::Request->new($method, $url);
    $req->content_type('application/json');
    $req->content(encode_json(\%json));

    # Execute the request with LWP
    my $lwp = LWP::UserAgent->new;
    my $res = $lwp->request($req);

    # Handle response
    if ($res->is_success) {
        print "HTTP $method success code & message: ", $res->code, " ", $res->message, "\n";
        if ($debug && $debug eq "debug") { 
            print "Received API reply: ", $res->decoded_content, "\n";
        }
    } else {
        print "HTTP $method error code & message: ", $res->code, " ", $res->message, "\n";
    }