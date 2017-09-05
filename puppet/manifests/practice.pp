# rpm -ivh http://yum.puppetlabs.com/el/7/products/x86_64/puppetlabs-release-22.0-2.noarch.rpm
# yum install puppet
# puppet module install puppetlabs-stdlib --version 4.18.0
# mkdir -p /etc/puppet/manifests
# vi /etc/puppet/manifests/practice.pp
# puppet apply practice.pp
#
#
# Puppet manifest
# Apache2.4 / php7
package {
  'epel-release':
    ensure   => 'installed',
    provider => 'yum';
  'remi-release-7':
    ensure   => 'installed',
    provider => 'rpm',
    source   => 'http://rpms.famillecollet.com/enterprise/remi-release-7.rpm';
  'git':
    ensure   => 'installed',
    provider => 'yum';
  'httpd':
    ensure   => 'installed',
    provider => 'yum',
}
$require_package = [
  "php",
  "php-opcache",
  "php-devel",
  "php-mbstring",
  "php-pdo",
  "php-gd",
  "php-xml",
  "php-mcrypt",
  "php-mysqlnd",
  "php-pecl-xdebug",
]
package { $require_package:
  ensure          => 'installed',
  install_options => ['--enablerepo=remi-php71'],
  provider        => 'yum',
  require         => Package['epel-release'],Package['remi-release-7']
}
service { 'httpd':
  name    => 'httpd',
  ensure  => running,
  require => Package['httpd']
}
