package GnaviApiExecSample;
use utf8;
use strict;
use warnings;
use LWP::UserAgent;
use JSON;
use URI::Escape;
use Data::Dumper;

use Class::Accessor::Lite (
    new => 0,
    rw  => [qw/ access_key format latitude longitude range /],
    ro  => [qw/ endpoint /],
);

sub new {
    my ($self, $params) = @_;
    bless +{
        endpoint   => 'http://api.gnavi.co.jp/RestSearchAPI/20150630/',
        access_key => $params->{access_key},
        format     => $params->{format} || 'json',
        latitude   => $params->{latitude} || 0,
        longitude  => $params->{longitude} || 0,
        range      => $params->{range} || 1,
    }, $self;
}

sub exec_api {
    my ($self) = @_;
    my $url = URI->new($self->endpoint);
    my %params = (
        keyid     => $self->access_key,
        format    => $self->format,
        latitude  => $self->latitude,
        longitude => $self->longitude,
        range     => $self->range,
    );
    $url->query_form(%params);
    my $ua = LWP::UserAgent->new;
    my $response = $ua->get($url);
    die 'Status: ' . $response->code . '  ' . $response->message
    unless ($response->is_success);
    return $response->content;
}

# The following run sample.
my $object = new GnaviApiExecSample({access_key => 'input your accessKey', format => 'json'});
print Data::Dumper::Dumper(decode_json($object->exec_api));
