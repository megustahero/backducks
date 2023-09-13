#!/usr/bin/perl

use warnings;
use strict;
use HTTP::Request;
use HTTP::Headers;
use LWP::UserAgent;
use JSON::PP;
use input;

if ($ARGV[0] eq 'start') {
    print "Starting the system...\n";
} elsif ($ARGV[0] eq 'stop') {
    print "Stopping the system...\n";
} else {
    print "Unknown command\n";
}

if (@ARGV != 1) {
    print "Usage: $0 <run|test> [unitnum1,unitnum2,...] \n";
    exit;
}

#die;

my $ua = LWP::UserAgent->new(ssl_opts => { SSL_verify_mode => 'SSL_VERIFY_NONE' });

sub command{
    my($host, $target, $method, $header_ref, $data_ref) = @_;
    my $data_json = %{$data_ref} ? encode_json($data_ref) : "";
    my $request = HTTP::Request->new($method => 
    "https://$host/$target", HTTP::Headers->new(%{$header_ref}), $data_json);
    $request->header(Content_Type => 'application/json');
    my $response = $ua->request($request);
    return decode_json($response->content);
}