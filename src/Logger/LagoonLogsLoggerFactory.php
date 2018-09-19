<?php

namespace Drupal\lagoon_logs\Logger;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LogMessageParserInterface;

class LagoonLogsLoggerFactory {
  public static function create(ConfigFactoryInterface $config, LogMessageParserInterface $parser) {
    $host = $config->get('lagoon_logs.settings')->get('host');
    $port = $config->get('lagoon_logs.settings')->get('port');
    return new LagoonLogsLogger($host, $port, self::getHostProcessIndex($config), $parser);
  }

  public static function getHostProcessIndex(ConfigFactoryInterface $config) {
    return implode('-', [
      $config->get('lagoon_logs.settings')->get('identifier'),
      getenv('LAGOON_PROJECT') ?: 'project_unset',
      getenv('LAGOON_GIT_SAFE_BRANCH') ?: 'safe_branch_unset',
    ]);
  }
}