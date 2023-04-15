<?php

namespace Kiri\Message;


enum ContentType
{

    case X;
    case OCTET_STREAM;
    case PDF;
    case AI;
    case ATOM_XML;
    case JS;
    case EDI_X12;
    case EDIFACT;
    case JSON;
    case JAVASCRIPT;
    case OGG;
    case RDF;
    case RSS_XML;
    case SOAP_XML;
    case WOFF;
    case XHTML_XML;
    case XML;
    case DTD;
    case XOP_XML;
    case ZIP;
    case GZIP;
    case XLS;
    case X_001;
    case X_301;
    case X_906;
    case A11;
    case AWF;
    case BMP;
    case C4T;
    case CAL;
    case CDF;
    case CEL;
    case CG4;
    case CIT;
    case BOT;
    case C90;
    case CAT;
    case CDR;
    case CER;
    case CGM;
    case CMX;
    case CRL;
    case CSI;
    case CUT;
    case DBM;
    case CMP;
    case COT;
    case CRT;
    case DBF;
    case DBX;
    case DCX;
    case DGN;
    case DLL;
    case DOT;
    case DER;
    case DIB;
    case DOC;
    case DRW;
    case DWF;
    case DXB;
    case EDN;
    case DWG;
    case DXF;
    case EMF;
    case EPI;
    case EPS;
    case EXE;
    case FDF;
    case X_EPS;
    case ETD;
    case FIF;
    case FRM;
    case GBR;
    case G4;
    case GL2;
    case HGL;
    case HPG;
    case HQX;
    case HTA;
    case GP4;
    case HMR;
    case HPL;
    case HRF;
    case ICB;
    case ICO;
    case IG4;
    case III;
    case INS;
    case IFF;
    case IGS;
    case IMG;
    case ISP;
    case JPE;
    case X_JAVASCRIPT;
    case JPG;
    case LAR;
    case LATEX;
    case LBM;
    case LS;
    case LTR;
    case MAN;
    case MDB;
    case MAC;
    case X_MDB;
    case MFP;
    case MI;
    case MIL;
    case MOCHA;
    case MPD;
    case MPP;
    case MPT;
    case MPW;
    case MPX;
    case MXP;
    case NRF;
    case OUT;
    case P12;
    case P7C;
    case P7R;
    case PC5;
    case PCL;
    case PDX;
    case PGL;
    case PKO;
    case P10;
    case P7B;
    case P7M;
    case P7S;
    case PCI;
    case PCX;
    case PFX;
    case PIC;
    case PL;
    case PLT;
    case PNG;
    case PPA;
    case PPS;
    case X_PPT;
    case PRF;
    case PRT;
    case PS;
    case PWZ;
    case RA;
    case RAS;
    case POT;
    case PPM;
    case PPT;
    case PR;
    case PRN;
    case X_PS;
    case PTN;
    case RED;
    case RJS;
    case RLC;
    case RM;
    case RAT;
    case REC;
    case RGB;
    case RJT;
    case RLE;
    case RMF;
    case RMJ;
    case RMP;
    case RMVB;
    case RNX;
    case RPM;
    case RMS;
    case RMX;
    case RSML;
    case RTF;
    case RV;
    case SAT;
    case SDW;
    case SLB;
    case X_RTF;
    case SAM;
    case SDP;
    case SIT;
    case SLD;
    case SMI;
    case SMK;
    case SMIL;
    case SPC;
    case SPL;
    case SSM;
    case STL;
    case SST;
    case TDF;
    case TGA;
    case STY;
    case SWF;
    case TG4;
    case TIF;
    case VDX;
    case VPG;
    case VSD;
    case VST;
    case VSW;
    case VTX;
    case TORRENT;
    case VDA;
    case VND_VISIO;
    case VSS;
    case X_VST;
    case VSX;
    case WB1;
    case WB3;
    case WIZ;
    case WK4;
    case WKS;
    case WB2;
    case WK3;
    case WKQ;
    case WMF;
    case WMD;
    case WP6;
    case WPG;
    case WQ1;
    case WRI;
    case WS;
    case WMZ;
    case WPD;
    case WPL;
    case WR1;
    case WRK;
    case WS2;
    case XDP;
    case XFD;
    case XFDF;
    case VND_MS_EXCEL;
    case XWD;
    case SIS;
    case X_T;
    case APK;
    case X_B;
    case SISX;
    case IPA;
    case XAP;
    case XLW;
    case XPL;
    case ANV;
    case UIN;
    case H323;
    case BIZ;
    case CML;
    case ASA;
    case ASP;
    case CSS;
    case CSV;
    case DCD;
    case X_DTD;
    case ENT;
    case FO;
    case HTC;
    case HTML;
    case HTX;
    case HTM;
    case HTT;
    case JSP;
    case MATH;
    case MML;
    case MTX;
    case PLG;
    case X_RDF;
    case RT;
    case SOL;
    case SPP;
    case STM;
    case SVG;
    case TLD;
    case TXT;
    case ULS;
    case VML;
    case TSD;
    case VCF;
    case VXML;
    case WML;
    case WSDL;
    case WSC;
    case XDR;
    case XQL;
    case XSD;
    case XSLT;
    case X_XML;
    case XQ;
    case XQUERY;
    case XSL;
    case XHTML;
    case ODC;
    case R3T;
    case SOR;
    case ACP;
    case AIF;
    case AIFF;
    case AIFC;
    case AU;
    case LA1;
    case LAVS;
    case LMSFF;
    case M3U;
    case MIDI;
    case MID;
    case MP2;
    case MP3;
    case MP4;
    case MND;
    case MP1;
    case MNS;
    case MPGA;
    case PLS;
    case RAM;
    case RMI;
    case RMM;
    case SND;
    case WAV;
    case WAX;
    case WMA;
    case ASF;
    case ASX;
    case AVI;
    case IVF;
    case M1V;
    case M2V;
    case M4E;
    case MOVIE;
    case MP2V;
    case X_MP4;
    case MPA;
    case MPE;
    case MPG;
    case MPEG;
    case MPS;
    case MPV;
    case MPV2;
    case WM;
    case WMV;
    case WMX;
    case WVX;
    case TIFF;
    case FAX;
    case GIF;
    case ICON;
    case JFIF;
    case X_JPE;
    case JPEG;
    case X_JPG;
    case NET;
    case X_PNG;
    case RP;
    case X_TIF;
    case X_TIFF;
    case WBMP;
    case EML;
    case MHT;
    case MHTML;
    case NWS;
    case D_907;
    case SLK;
    case TOP;
    case JAVA_CLASS;
    case JAVA;
    case X_DWF;


    /**
     * @param $method
     * @return string
     */
    public function toString(): string
    {
        return match ($this) {
            self::X => 'application/x-',
            self::OCTET_STREAM => 'application/octet-stream',
            self::PDF => 'application/pdf',
            self::AI, self::EPS, self::PS => 'application/postscript',
            self::ATOM_XML => 'application/atom+xml',
            self::JS => 'application/ecmascript',
            self::EDI_X12 => 'application/EDI-X12',
            self::EDIFACT => 'application/EDIFACT',
            self::JSON => 'application/json; charset=utf-8',
            self::JAVASCRIPT => 'application/javascript; charset=utf-8',
            self::OGG => 'application/ogg',
            self::RDF => 'application/rdf+xml',
            self::RSS_XML => 'application/rss+xml',
            self::SOAP_XML => 'application/soap+xml',
            self::WOFF => 'application/font-woff',
            self::XHTML_XML => 'application/xhtml+xml',
            self::XML => 'application/xml; charset=utf-8',
            self::DTD => 'application/xml-dtd',
            self::XOP_XML => 'application/xop+xml',
            self::ZIP => 'application/zip',
            self::GZIP => 'application/gzip',
            self::XLS => 'application/x-xls',
            self::X_001 => 'application/x-001',
            self::X_301 => 'application/x-301',
            self::X_906 => 'application/x-906',
            self::A11 => 'application/x-a11',
            self::AWF => 'application/vnd.adobe.workflow',
            self::BMP => 'application/x-bmp',
            self::C4T => 'application/x-c4t',
            self::CAL => 'application/x-cals',
            self::CDF => 'application/x-netcdf',
            self::CEL => 'application/x-cel',
            self::CG4, self::G4, self::IG4 => 'application/x-g4',
            self::CIT => 'application/x-cit',
            self::BOT => 'application/x-bot',
            self::C90 => 'application/x-c90',
            self::CAT => 'application/vnd.ms-pki.seccat',
            self::CDR => 'application/x-cdr',
            self::CER, self::CRT, self::DER => 'application/x-x509-ca-cert',
            self::CGM => 'application/x-cgm',
            self::CMX => 'application/x-cmx',
            self::CRL => 'application/pkix-crl',
            self::CSI => 'application/x-csi',
            self::CUT => 'application/x-cut',
            self::DBM => 'application/x-dbm',
            self::CMP => 'application/x-cmp',
            self::COT => 'application/x-cot',
            self::DBF => 'application/x-dbf',
            self::DBX => 'application/x-dbx',
            self::DCX => 'application/x-dcx',
            self::DGN => 'application/x-dgn',
            self::DLL, self::EXE => 'application/x-msdownload',
            self::DOT, self::DOC, self::RTF, self::WIZ => 'application/msword',
            self::DIB => 'application/x-dib',
            self::DRW => 'application/x-drw',
            self::DWF => 'application/x-dwf',
            self::DXB => 'application/x-dxb',
            self::EDN => 'application/vnd.adobe.edn',
            self::DWG => 'application/x-dwg',
            self::DXF => 'application/x-dxf',
            self::EMF => 'application/x-emf',
            self::EPI => 'application/x-epi',
            self::FDF => 'application/vnd.fdf',
            self::X_EPS, self::X_PS => 'application/x-ps',
            self::ETD => 'application/x-ebx',
            self::FIF => 'application/fractals',
            self::FRM => 'application/x-frm',
            self::GBR => 'application/x-gbr',
            self::GL2 => 'application/x-gl2',
            self::HGL => 'application/x-hgl',
            self::HPG => 'application/x-hpgl',
            self::HQX => 'application/mac-binhex40',
            self::HTA => 'application/hta',
            self::GP4 => 'application/x-gp4',
            self::HMR => 'application/x-hmr',
            self::HPL => 'application/x-hpl',
            self::HRF => 'application/x-hrf',
            self::ICB => 'application/x-icb',
            self::ICO => 'application/x-ico',
            self::III => 'application/x-iphone',
            self::INS, self::ISP => 'application/x-internet-signup',
            self::IFF => 'application/x-iff',
            self::IGS => 'application/x-igs',
            self::IMG => 'application/x-img',
            self::JPE => 'application/x-jpe',
            self::X_JAVASCRIPT, self::LS, self::MOCHA => 'application/x-javascript',
            self::JPG => 'application/x-jpg',
            self::LAR => 'application/x-laplayer-reg',
            self::LATEX => 'application/x-latex',
            self::LBM => 'application/x-lbm',
            self::LTR => 'application/x-ltr',
            self::MAN => 'application/x-troff-man',
            self::MDB => 'application/msaccess',
            self::MAC => 'application/x-mac',
            self::X_MDB => 'application/x-mdb',
            self::MFP, self::SWF => 'application/x-shockwave-flash',
            self::MI => 'application/x-mi',
            self::MIL => 'application/x-mil',
            self::MPD, self::MPP, self::MPT, self::MPW, self::MPX => 'application/vnd.ms-project',
            self::MXP => 'application/x-mmxp',
            self::NRF => 'application/x-nrf',
            self::OUT => 'application/x-out',
            self::P12, self::PFX => 'application/x-pkcs12',
            self::P7C, self::P7M => 'application/pkcs7-mime',
            self::P7R => 'application/x-pkcs7-certreqresp',
            self::PC5 => 'application/x-pc5',
            self::PCL => 'application/x-pcl',
            self::PDX => 'application/vnd.adobe.pdx',
            self::PGL => 'application/x-pgl',
            self::PKO => 'application/vnd.ms-pki.pko',
            self::P10 => 'application/pkcs10',
            self::P7B, self::SPC => 'application/x-pkcs7-certificates',
            self::P7S => 'application/pkcs7-signature',
            self::PCI => 'application/x-pci',
            self::PCX => 'application/x-pcx',
            self::PIC => 'application/x-pic',
            self::PL => 'application/x-perl',
            self::PLT => 'application/x-plt',
            self::PNG => 'application/x-png',
            self::PPA, self::PPS, self::PWZ, self::POT, self::PPT => 'application/vnd.ms-powerpoint',
            self::X_PPT => 'application/x-ppt',
            self::PRF => 'application/pics-rules',
            self::PRT => 'application/x-prt',
            self::RA => 'audio/vnd.rn-realaudio',
            self::RAS => 'application/x-ras',
            self::PPM => 'application/x-ppm',
            self::PR => 'application/x-pr',
            self::PRN => 'application/x-prn',
            self::PTN => 'application/x-ptn',
            self::RED => 'application/x-red',
            self::RJS => 'application/vnd.rn-realsystem-rjs',
            self::RLC => 'application/x-rlc',
            self::RM => 'application/vnd.rn-realmedia',
            self::RAT => 'application/rat-file',
            self::REC => 'application/vnd.rn-recording',
            self::RGB => 'application/x-rgb',
            self::RJT => 'application/vnd.rn-realsystem-rjt',
            self::RLE => 'application/x-rle',
            self::RMF => 'application/vnd.adobe.rmf',
            self::RMJ => 'application/vnd.rn-realsystem-rmj',
            self::RMP => 'application/vnd.rn-rn_music_package',
            self::RMVB => 'application/vnd.rn-realmedia-vbr',
            self::RNX => 'application/vnd.rn-realplayer',
            self::RPM => 'audio/x-pn-realaudio-plugin',
            self::RMS => 'application/vnd.rn-realmedia-secure',
            self::RMX => 'application/vnd.rn-realsystem-rmx',
            self::RSML => 'application/vnd.rn-rsml',
            self::RV => 'video/vnd.rn-realvideo',
            self::SAT => 'application/x-sat',
            self::SDW => 'application/x-sdw',
            self::SLB => 'application/x-slb',
            self::X_RTF => 'application/x-rtf',
            self::SAM => 'application/x-sam',
            self::SDP => 'application/sdp',
            self::SIT => 'application/x-stuffit',
            self::SLD => 'application/x-sld',
            self::SMI, self::SMIL => 'application/smil',
            self::SMK => 'application/x-smk',
            self::SPL => 'application/futuresplash',
            self::SSM => 'application/streamingmedia',
            self::STL => 'application/vnd.ms-pki.stl',
            self::SST => 'application/vnd.ms-pki.certstore',
            self::TDF => 'application/x-tdf',
            self::TGA => 'application/x-tga',
            self::STY => 'application/x-sty',
            self::TG4 => 'application/x-tg4',
            self::TIF => 'application/x-tif',
            self::VDX, self::VST, self::VSW, self::VTX, self::VND_VISIO, self::VSS, self::VSX => 'application/vnd.visio',
            self::VPG => 'application/x-vpeg005',
            self::VSD => 'application/x-vsd',
            self::TORRENT => 'application/x-bittorrent',
            self::VDA => 'application/x-vda',
            self::X_VST => 'application/x-vst',
            self::WB1 => 'application/x-wb1',
            self::WB3 => 'application/x-wb3',
            self::WK4 => 'application/x-wk4',
            self::WKS => 'application/x-wks',
            self::WB2 => 'application/x-wb2',
            self::WK3 => 'application/x-wk3',
            self::WKQ => 'application/x-wkq',
            self::WMF => 'application/x-wmf',
            self::WMD => 'application/x-ms-wmd',
            self::WP6 => 'application/x-wp6',
            self::WPG => 'application/x-wpg',
            self::WQ1 => 'application/x-wq1',
            self::WRI => 'application/x-wri',
            self::WS, self::WS2 => 'application/x-ws',
            self::WMZ => 'application/x-ms-wmz',
            self::WPD => 'application/x-wpd',
            self::WPL => 'application/vnd.ms-wpl',
            self::WR1 => 'application/x-wr1',
            self::WRK => 'application/x-wrk',
            self::XDP => 'application/vnd.adobe.xdp',
            self::XFD => 'application/vnd.adobe.xfd',
            self::XFDF => 'application/vnd.adobe.xfdf',
            self::VND_MS_EXCEL => 'application/vnd.ms-excel',
            self::XWD => 'application/x-xwd',
            self::SIS, self::SISX => 'application/vnd.symbian.install',
            self::X_T => 'application/x-x_t',
            self::APK => 'application/vnd.android.package-archive',
            self::X_B => 'application/x-x_b',
            self::IPA => 'application/vnd.iphone',
            self::XAP => 'application/x-silverlight-app',
            self::XLW => 'application/x-xlw',
            self::XPL, self::PLS => 'audio/scpls',
            self::ANV => 'application/x-anv',
            self::UIN => 'application/x-icq',
            self::H323 => 'text/h323',
            self::BIZ, self::CML, self::DCD, self::X_DTD, self::FO, self::ENT, self::MATH, self::MML, self::MTX, self::X_RDF, self::SPP, self::SVG, self::TLD, self::VML, self::TSD, self::VXML, self::WSDL, self::XDR, self::XSD, self::XQL, self::XSLT, self::X_XML, self::XQ, self::XQUERY, self::XSL => 'text/xml; charset=utf-8',
            self::ASA => 'text/asa',
            self::ASP => 'text/asp',
            self::CSS => 'text/css',
            self::CSV => 'text/csv',
            self::HTC => 'text/x-component',
            self::HTML, self::STM, self::HTX, self::HTM, self::JSP, self::PLG, self::XHTML => 'text/html; charset=utf-8',
            self::HTT => 'text/webviewhtml',
            self::RT => 'text/vnd.rn-realtext',
            self::SOL, self::SOR => 'text/plain',
            self::TXT => 'text/plain纯文字内容',
            self::ULS => 'text/iuls',
            self::VCF => 'text/x-vcard',
            self::WML => 'text/vnd.wap.wml',
            self::WSC => 'text/scriptlet',
            self::ODC => 'text/x-ms-odc',
            self::R3T => 'text/vnd.rn-realtext3d',
            self::ACP => 'audio/x-mei-aac',
            self::AIF, self::AIFF, self::AIFC => 'audio/aiff',
            self::AU, self::SND => 'audio/basic',
            self::LA1 => 'audio/x-liquid-file',
            self::LAVS => 'audio/x-liquid-secure',
            self::LMSFF => 'audio/x-la-lms',
            self::M3U => 'audio/mpegurl',
            self::MIDI, self::MID, self::RMI => 'audio/mid',
            self::MP2 => 'audio/mp2',
            self::MP3 => 'audio/mp3',
            self::MP4 => 'audio/mp4',
            self::MND => 'audio/x-musicnet-download',
            self::MP1 => 'audio/mp1',
            self::MNS => 'audio/x-musicnet-stream',
            self::MPGA => 'audio/rn-mpeg',
            self::RAM, self::RMM => 'audio/x-pn-realaudio',
            self::WAV => 'audio/wav',
            self::WAX => 'audio/x-ms-wax',
            self::WMA => 'audio/x-ms-wma',
            self::ASF, self::ASX => 'video/x-ms-asf',
            self::AVI => 'video/avi',
            self::IVF => 'video/x-ivf',
            self::M1V, self::M2V, self::MPE, self::MPS => 'video/x-mpeg',
            self::M4E, self::X_MP4 => 'video/mpeg4',
            self::MOVIE => 'video/x-sgi-movie',
            self::MP2V, self::MPV2 => 'video/mpeg',
            self::MPA => 'video/x-mpg',
            self::MPG, self::MPEG, self::MPV => 'video/mpg',
            self::WM => 'video/x-ms-wm',
            self::WMV => 'video/x-ms-wmv',
            self::WMX => 'video/x-ms-wmx',
            self::WVX => 'video/x-ms-wvx',
            self::TIFF, self::X_TIF, self::X_TIFF => 'image/tiff',
            self::FAX => 'image/fax',
            self::GIF => 'image/gif',
            self::ICON => 'image/x-icon',
            self::JFIF, self::X_JPE, self::JPEG, self::X_JPG => 'image/jpeg',
            self::NET => 'image/pnetvue',
            self::X_PNG => 'image/png',
            self::RP => 'image/vnd.rn-realpix',
            self::WBMP => 'image/vnd.wap.wbmp',
            self::EML, self::MHT, self::MHTML, self::NWS => 'message/rfc822',
            self::D_907 => 'drawing/907',
            self::SLK => 'drawing/x-slk',
            self::TOP => 'drawing/x-top',
            self::JAVA_CLASS, self::JAVA => 'java/*',
            self::X_DWF => 'Model/vnd.dwf'
        };
    }
}
