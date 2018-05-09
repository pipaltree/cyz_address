<?php

/*
 * This file is part of the "Cyz_Address" Extension for TYPO3 CMS.
 * (c) 2017 Luca Kredel <luca.kredel@cyperfection.de>, cyperfection gmbh
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Override image '0' type in order to use the imageoverlayPalette - somehow tt_address does not have all fields
 * of imageoverlayPalette in it's backend form although imageoverlayPalette is set in TCA...
 *
 * The purpose of this is to enable the crop function for images
 */

$tempCols = [
    '0' => [
        'showitem' => '
            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
            --palette--;;filePalette'
    ],
    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
        'showitem' => '
            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
            --palette--;;filePalette'
    ],
    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
        'showitem' => '
            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
            --palette--;;filePalette'
    ],
    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
        'showitem' => '
            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
            --palette--;;filePalette'
    ],
    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
        'showitem' => '
            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
            --palette--;;filePalette'
    ],
    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
        'showitem' => '
            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
            --palette--;;filePalette'
    ]
];

$GLOBALS['TCA']['tt_address']['columns']['image']['config']['overrideChildTca']['types'] = $tempCols;


$GLOBALS['TCA']['tt_address']['ctrl']['sortby'] = 'sorting';

$temporaryColumns = [
    'sys_language_uid' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'special'    => 'languages',
        ],
    ],
    'l10n_parent'      => [
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'exclude'     => 1,
        'label'       => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
        'config'      => [
            'type'                => 'select',
            'renderType'          => 'selectSingle',
            'items'               => [
                ['', 0],
            ],
            'foreign_table'       => 'tt_address',
            'foreign_table_where' => 'AND tt_address.pid=###CURRENT_PID### AND tt_address.sys_language_uid IN (-1,0)',
        ],
    ],
    'l10n_diffsource'  => [
        'config' => [
            'type' => 'passthrough',
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_address',
    $temporaryColumns
);

\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TCA']['tt_address'],
    [
        'ctrl'  => [
            'languageField'            => 'sys_language_uid',
            'transOrigPointerField'    => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
        ],
        'types' => [
            0 => [
                'showitem' => '--palette--;General;general,--palette--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_palette.name;name,image,description,--div--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_tab.contact,--palette--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_palette.address;address,--palette--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_palette.building;building,--palette--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_palette.organization;organization,--palette--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_palette.contact;contact,--palette--;LLL:EXT:tt_address/locallang_tca.xml:tt_address_palette.social;social,--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,categories',
            ]
        ],
        'palettes' => [
            'general' => [
                'cannotCollapse' => 1,
                'showitem' => 'hidden,sys_language_uid,l10n_parent',
            ]
        ]
    ]
);
