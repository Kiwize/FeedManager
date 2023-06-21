<?php

namespace App\Services\TagsExtractor\Constants;

final class TagsExtractorConstants
{

    /** @var array */
    public static $keywords = [
        'Windows',
        'Apple',
        'macOS',
        'Linux',
        'Android',
        'iOS',
        'OSX',
        'Chrome',
        'Firefox',
        'Edge',
        'Opera',
        'Safari',
        'FreeBSD',
        'Solaris',
        'VMware',
        'ESXi',
        'Microsoft',
        'Hyper-V',
        'Oracle',
        'VM',
        'VirtualBox',
        'KVM',
        'Xen',
        'Citrix',
        'Hypervisor',
        'Proxmox',
        'VMware',
        'Workstation'
    ];

    /** @var array */
    public static $charsToOmit = ["'", "`", "’", "+", ",", ".", "'", "\"", "&", "!", "?", ":", ";", "#", "~", "=", "/", "$", "£", "^", "(", ")", "_", "<", ">", "«", "»"];
}
