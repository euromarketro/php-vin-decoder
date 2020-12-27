<?php
/*
	Produced 2019
	By https://amattu.com/links/github
	Copy Alec M.
	License GNU Affero General Public License v3.0
*/

// Exception Classes
class InvalidLengthException extends Exception {}
class InvalidCharacterException extends Exception {}
class InvalidYearException extends Exception {}
class EmptyOperationException extends Exception {}
class DecodedYearMismatch extends Exception {}

// Vehicle Identification Number Class
class VIN {
	// Class Variables
	protected $VIN = "";
	protected $Year = 0;
	protected $Country = "";
	protected $Region = "";
	protected $_Characters = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";
	protected $_YearMinimum = 1966;

	/**
	* Class constructor
	*
	* @param string $vin
	* @return None
	* @throws TypeError, InvalidLengthException, InvalidCharacterException, InvalidYearException
	**/
	public function __construct(string $vin, int $year = 0) {
		// Checks
		if (strlen($vin) !== 17) {
			throw new InvalidLengthException("VIN length is not 17 characters");
		}
		if ($this->validate($vin) !== true) {
			throw new InvalidCharacterException("VIN contains a invalid character");
		}
		if ($year !== 0 && $year < $_YearMinimum) {
			throw new InvalidYearException("VIN year provided is unsupported");
		}

		// Variables
		$this->VIN = strtoupper($vin);
		$this->Year = $year;
	}

	/**
	* Class stringify method
	*
	* @param None
	* @return string $vin
	* @throws None
	**/
	public function __tostring() : string {
		// Return
		return sprintf("VIN:%s Country:%s Region:%s", $this->VIN, $this->country(), $this->region());
	}

	/**
	* Detect vehicle production country
	*
	* @param None
	* @return string $country
	* @throws EmptyOperationException
	*/
	public function country() : string {
		return "";
	}

	/**
	* Detect vehicle production region
	*
	* @param None
	* @return string $region
	* @throws EmptyOperationException
	*/
	public function region() : string {
		return "";
	}

	/**
	* Detect vehicle production manufacturer
	*
	* @param None
	* @return string $manufacturer
	* @throws EmptyOperationException
	*/
	public function manufacturer() : string {
		
		$brand = strtoupper(substr($this->VIN,0,3));  # extract first 3 letters that represent WMI identifier
			/*
			* Info source: https://en.wikibooks.org/wiki/Vehicle_Identification_Numbers_(VIN_codes)/World_Manufacturer_Identifier_(WMI)
			* Update by Socol Ionut - www.euromarket.ro
			*/				

			# 2 letters identifier
			if($brand == 'JA')  { $brand = 'Isuzu'; }
			if($brand == 'JD')  { $brand = 'Daihatsu'; }
			if($brand == 'JF')  { $brand = 'Fuji Heavy Industries (Subaru)'; }
			if($brand == 'JK')  { $brand = 'Kawasaki (motorcycles)'; }
			if($brand == 'JN')  { $brand = 'Nissan'; }
			if($brand == 'JS')  { $brand = 'Suzuki'; }
			if($brand == 'JT')  { $brand = 'Toyota'; }
			if($brand == 'JY')  { $brand = 'Yamaha (motorcycles)'; }
			if($brand == 'KL')  { $brand = 'Daewoo General Motors South Korea'; }
			if($brand == 'KM')  { $brand = 'Hyundai'; }
			if($brand == 'KN')  { $brand = 'Kia'; }
			if($brand == '1G')  { $brand = 'General Motors USA'; }
			if($brand == '1H')  { $brand = 'Honda USA'; }
			if($brand == '1L')  { $brand = 'Lincoln USA'; }
			if($brand == '1N')  { $brand = 'Nissan USA'; }
			if($brand == '4F')  { $brand = 'Mazda USA'; }
			if($brand == '2M')  { $brand = 'Mercury'; }
			if($brand == '2T')  { $brand = 'Toyota Canada'; }
			if($brand == '3G')  { $brand = 'General Motors Mexico'; }
			if($brand == '3H')  { $brand = 'Honda Mexico'; }
			if($brand == '3N')  { $brand = 'Nissan Mexico'; }
			if($brand == '4S')  { $brand = 'Subaru-Isuzu Automotive'; }
			if($brand == '4T')  { $brand = 'Toyota'; }
			if($brand == '5F')  { $brand = 'Honda USA-Alabama'; }
			if($brand == '5J')  { $brand = 'Honda USA-Ohio'; }
			if($brand == '5L')  { $brand = 'Lincoln'; }
			if($brand == '5T')  { $brand = 'Toyota USA - trucks'; }
			
			if($brand == 'AAV')  { $brand = 'Volkswagen South Africa'; }
			if($brand == 'AC5')  { $brand = 'Hyundai South Africa'; }
			if($brand == 'ADD')  { $brand = 'Hyundai South Africa'; }
			if($brand == 'AFA')  { $brand = 'Ford South Africa'; }
			if($brand == 'AHT')  { $brand = 'Toyota South Africa'; }
			if($brand == 'JA3')  { $brand = 'Mitsubishi'; }
			if($brand == 'JA4')  { $brand = 'Mitsubishi'; }
			if($brand == 'JHA')  { $brand = 'Hino'; }
			if($brand == 'JHE')  { $brand = 'Hino'; }
			if($brand == 'JHF')  { $brand = 'Honda'; }
			if($brand == 'JHG')  { $brand = 'Honda'; }
			if($brand == 'JHL')  { $brand = 'Honda'; }
			if($brand == 'JHN')  { $brand = 'Honda'; }
			if($brand == 'JHZ')  { $brand = 'Honda'; }		
			if($brand == 'JL5')  { $brand = 'Mitsubishi Fuso'; }
			if($brand == 'JM1')  { $brand = 'Mazda'; }
			if($brand == 'JMB')  { $brand = 'Mitsubishi Motors'; }
			if($brand == 'JMY')  { $brand = 'Mitsubishi Motors'; }
			if($brand == 'JMZ')  { $brand = 'Mazda'; }			
			if($brand == 'KMY')  { $brand = 'Daelim (motorcycles)'; }
			if($brand == 'KM1')  { $brand = 'Hyosung (motorcycles)'; }			
			if($brand == 'KNM')  { $brand = 'Renault Samsung'; }
			if($brand == 'KPA')  { $brand = 'SsangYong'; }
			if($brand == 'KPT')  { $brand = 'SsangYong'; }
			if($brand == 'LAE')  { $brand = 'Jinan Qingqi Motorcycle'; }
			if($brand == 'LAL')  { $brand = 'Sundiro Honda Motorcycle'; }
			if($brand == 'LAN')  { $brand = 'Changzhou Yamasaki Motorcycle'; }
			if($brand == 'LBB')  { $brand = 'Zhejiang Qianjiang Motorcycle (Keeway/Generic)'; }
			if($brand == 'LBE')  { $brand = 'Beijing Hyundai'; }
			if($brand == 'LBM')  { $brand = 'Zongshen Piaggio'; }
			if($brand == 'LBP')  { $brand = 'Chongqing Jainshe Yamaha (motorcycles)'; }
			if($brand == 'LB2')  { $brand = 'Geely Motorcycles'; }
			if($brand == 'LCE')  { $brand = 'Hangzhou Chunfeng Motorcycles (CFMOTO)'; }
			if($brand == 'LDC')  { $brand = 'Dong Feng Peugeot Citroen (DPCA), China'; }
			if($brand == 'LDD')  { $brand = 'Dandong Huanghai Automobile'; }
			if($brand == 'LDF')  { $brand = 'Dezhou Fulu Vehicle (motorcycles)'; }
			if($brand == 'LDN')  { $brand = 'SouEast Motor'; }
			if($brand == 'LDY')  { $brand = 'Zhongtong Coach, China'; }
			if($brand == 'LET')  { $brand = 'Jiangling-Isuzu Motors, China'; }
			if($brand == 'LE4')  { $brand = 'Beijing Benz, China'; }
			if($brand == 'LFB')  { $brand = 'FAW, China (busses)'; }
			if($brand == 'LFG')  { $brand = 'Taizhou Chuanl Motorcycle Manufacturing'; }
			if($brand == 'LFP')  { $brand = 'FAW, China (passenger vehicles)'; }
			if($brand == 'LFT')  { $brand = 'FAW, China (trailers)'; }
			if($brand == 'LFV')  { $brand = 'FAW-Volkswagen, China'; }
			if($brand == 'LFW')  { $brand = 'FAW JieFang, China'; }
			if($brand == 'LFY')  { $brand = 'Changshu Light Motorcycle Factory'; }
			if($brand == 'LGB')  { $brand = 'Dong Feng (DFM), China'; }
			if($brand == 'LGH')  { $brand = 'Qoros (formerly Dong Feng (DFM)), China'; }
			if($brand == 'LGX')  { $brand = 'BYD Auto, China'; }
			if($brand == 'LHB')  { $brand = 'Beijing Automotive Industry Holding'; }
			if($brand == 'LH1')  { $brand = 'FAW-Haima, China'; }
			if($brand == 'LJC')  { $brand = 'JAC, China'; }
			if($brand == 'LJ1')  { $brand = 'JAC, China'; }
			if($brand == 'LKL')  { $brand = 'Suzhou King Long, China'; }
			if($brand == 'LL6')  { $brand = 'Hunan Changfeng Manufacture Joint-Stock'; }
			if($brand == 'LL8')  { $brand = 'Linhai (ATV)'; }
			if($brand == 'LMC')  { $brand = 'Suzuki Hong Kong (motorcycles)'; }
			if($brand == 'LPR')  { $brand = 'Yamaha Hong Kong (motorcycles)'; }
			if($brand == 'LPS')  { $brand = 'Polestar (Volvo) (Sweden)'; }
			if($brand == 'LSG')  { $brand = 'Shanghai General Motors, China'; }
			if($brand == 'LSJ')  { $brand = 'MG Motor UK Limited - SAIC Motor, Shanghai, China'; }
			if($brand == 'LSV')  { $brand = 'Shanghai Volkswagen, China'; }
			if($brand == 'LSY')  { $brand = 'Brilliance Zhonghua'; }
			if($brand == 'LTP')  { $brand = 'National Electric Vehicle Sweden AB (NEVS)'; }
			if($brand == 'LTV')  { $brand = 'Toyota Tian Jin'; }
			if($brand == 'LUC')  { $brand = 'Guangqi Honda, China'; }
			if($brand == 'LVS')  { $brand = 'Ford Chang An'; }
			if($brand == 'LVV')  { $brand = 'Chery, China'; }
			if($brand == 'LVZ')  { $brand = 'Dong Feng Sokon Motor Company (DFSK)'; }
			if($brand == 'LV3')  { $brand = 'National Electric Vehicle Sweden AB (NEVS)'; }
			if($brand == 'LZM')  { $brand = 'MAN China'; }
			if($brand == 'LZE')  { $brand = 'Isuzu Guangzhou, China'; }
			if($brand == 'LZG')  { $brand = 'Shaanxi Automobile Group, China'; }
			if($brand == 'LZP')  { $brand = 'Zhongshan Guochi Motorcycle (Baotian)'; }
			if($brand == 'LZY')  { $brand = 'Yutong Zhengzhou, China'; }
			if($brand == 'LZZ')  { $brand = 'Chongqing Shuangzing Mech & Elec (Howo)'; }
			if($brand == 'L4B')  { $brand = 'Xingyue Group (motorcycles)'; }
			if($brand == 'L5C')  { $brand = 'KangDi (ATV)'; }
			if($brand == 'L5K')  { $brand = 'Zhejiang Yongkang Easy Vehicle'; }
			if($brand == 'L5N')  { $brand = 'Zhejiang Taotao, China (ATV & motorcycles)'; }
			if($brand == 'L5Y')  { $brand = 'Merato Motorcycle Taizhou Zhongneng'; }
			if($brand == 'L85')  { $brand = 'Zhejiang Yongkang Huabao Electric Appliance'; }
			if($brand == 'L8X')  { $brand = 'Zhejiang Summit Huawin Motorcycle'; }
			if($brand == 'MAB')  { $brand = 'Mahindra & Mahindra'; }
			if($brand == 'MAC')  { $brand = 'Mahindra & Mahindra'; }
			if($brand == 'MAJ')  { $brand = 'Ford India'; }
			if($brand == 'MAK')  { $brand = 'Honda Siel Cars India'; }
			if($brand == 'MAL')  { $brand = 'Hyundai India'; }
			if($brand == 'MAT')  { $brand = 'Tata Motors'; }
			if($brand == 'MA1')  { $brand = 'Mahindra & Mahindra'; }
			if($brand == 'MA3')  { $brand = 'Suzuki India (Maruti)'; }
			if($brand == 'MA6')  { $brand = 'GM India'; }
			if($brand == 'MA7')  { $brand = 'Mitsubishi India (formerly Honda)'; }
			if($brand == 'MB8')  { $brand = 'Suzuki India Motorcycles'; }
			if($brand == 'MBH')  { $brand = 'Suzuki India (Maruti)'; }
			if($brand == 'MBJ')  { $brand = 'Toyota India'; }
			if($brand == 'MBR')  { $brand = 'Mercedes-Benz India'; }
			if($brand == 'MB1')  { $brand = 'Ashok Leyland'; }
			if($brand == 'MCA')  { $brand = 'Fiat India'; }
			if($brand == 'MCB')  { $brand = 'GM India'; }
			if($brand == 'MC2')  { $brand = 'Volvo Eicher commercial vehicles limited.'; }
			if($brand == 'MDH')  { $brand = 'Nissan India'; }
			if($brand == 'MD2')  { $brand = 'Bajaj Auto'; }
			if($brand == 'MD9')  { $brand = 'Shuttle Cars India'; }
			if($brand == 'MEC')  { $brand = 'Daimler India Commercial Vehicles'; }
			if($brand == 'MEE')  { $brand = 'Renault India'; }
			if($brand == 'MEX')  { $brand = 'Volkswagen India'; }
			if($brand == 'MHF')  { $brand = 'Toyota Indonesia'; }
			if($brand == 'MHR')  { $brand = 'Honda Indonesia'; }
			if($brand == 'MLC')  { $brand = 'Suzuki Thailand'; }
			if($brand == 'NAA')  { $brand = 'Iran Khodro (Peugeot Iran)'; }
			if($brand == 'NAP')  { $brand = 'Pars Khodro'; }
			if($brand == 'MLH')  { $brand = 'Honda Thailand'; }
			if($brand == 'MMA')  { $brand = 'Mitsubishi Thailand'; }
			if($brand == 'MMB')  { $brand = 'Mitsubishi Thailand'; }
			if($brand == 'MMC')  { $brand = 'Mitsubishi Thailand'; }
			if($brand == 'MMM')  { $brand = 'Chevrolet Thailand'; }
			if($brand == 'MMS')  { $brand = 'Suzuki Thailand'; }
			if($brand == 'MMT')  { $brand = 'Mitsubishi Thailand'; }
			if($brand == 'MMU')  { $brand = 'Holden Thailand'; }
			if($brand == 'MM8')  { $brand = 'Mazda Thailand'; }
			if($brand == 'MNB')  { $brand = 'Ford Thailand'; }
			if($brand == 'MNT')  { $brand = 'Nissan Thailand'; }
			if($brand == 'MPA')  { $brand = 'Isuzu Thailand'; }
			if($brand == 'MP1')  { $brand = 'Isuzu Thailand'; }
			if($brand == 'MRH')  { $brand = 'Honda Thailand'; }
			if($brand == 'MR0')  { $brand = 'Toyota Thailand'; }
			if($brand == 'MS0')  { $brand = 'SSS MOTORS Myanmar'; }
			if($brand == 'MS3')  { $brand = 'Suzuki Myanmar Motor Co.,Ltd.'; }
			if($brand == 'NLA')  { $brand = 'Honda Türkiye'; }
			if($brand == 'NLE')  { $brand = 'Mercedes-Benz Türk Truck'; }
			if($brand == 'NLH')  { $brand = 'Hyundai Assan'; }
			if($brand == 'NLR')  { $brand = 'OTOKAR'; }
			if($brand == 'NLT')  { $brand = 'TEMSA'; }
			if($brand == 'NMB')  { $brand = 'Mercedes-Benz Türk Buses'; }
			if($brand == 'NMC')  { $brand = 'BMC'; }
			if($brand == 'NM0')  { $brand = 'Ford Turkey'; }
			if($brand == 'NM4')  { $brand = 'Tofaş Türk'; }
			if($brand == 'NMT')  { $brand = 'Toyota Türkiye'; }
			if($brand == 'NNA')  { $brand = 'Isuzu Turkey'; }
			if($brand == 'PE1')  { $brand = 'Ford Philippines'; }
			if($brand == 'PE3')  { $brand = 'Mazda Philippines'; }
			if($brand == 'PL1')  { $brand = 'Proton, Malaysia'; }
			if($brand == 'PNA')  { $brand = 'NAZA, Malaysia (Peugeot)'; }
			if($brand == 'R2P')  { $brand = 'Evoke Electric Motorcycles HK'; }
			if($brand == 'RA1')  { $brand = 'Steyr Trucks International FZE, UAE'; }
			if($brand == 'RFB')  { $brand = 'Kymco, Taiwan'; }
			if($brand == 'RFG')  { $brand = 'Sanyang SYM, Taiwan'; }
			if($brand == 'RFL')  { $brand = 'Adly, Taiwan'; }
			if($brand == 'RFT')  { $brand = 'CPI, Taiwan'; }
			if($brand == 'RF3')  { $brand = 'Aeon Motor, Taiwan'; }
			if($brand == 'SAB')  { $brand = 'Optare'; }
			if($brand == 'SAD')  { $brand = 'Jaguar (F-Pace, I-Pace)'; }
			if($brand == 'SAL')  { $brand = 'Land Rover'; }
			if($brand == 'SAJ')  { $brand = 'Jaguar'; }
			if($brand == 'SAR')  { $brand = 'Rover'; }
			if($brand == 'SAX')  { $brand = 'Austin-Rover'; }
			if($brand == 'SB1')  { $brand = 'Toyota UK'; }
			if($brand == 'SBM')  { $brand = 'McLaren'; }
			if($brand == 'SCA')  { $brand = 'Rolls Royce'; }
			if($brand == 'SCB')  { $brand = 'Bentley'; }
			if($brand == 'SCC')  { $brand = 'Lotus Cars'; }
			if($brand == 'SCE')  { $brand = 'DeLorean Motor Cars N. Ireland (UK)'; }
			if($brand == 'SCF')  { $brand = 'Aston'; }
			if($brand == 'SCK')  { $brand = 'iFor Williams'; }
			if($brand == 'SDB')  { $brand = 'Peugeot UK (formerly Talbot)'; }
			if($brand == 'SED')  { $brand = 'General Motors Luton Plant'; }
			if($brand == 'SEY')  { $brand = 'LDV'; }
			if($brand == 'SFA')  { $brand = 'Ford UK'; }
			if($brand == 'SFD')  { $brand = 'Alexander Dennis UK'; }
			if($brand == 'SHH')  { $brand = 'Honda UK'; }
			if($brand == 'SHS')  { $brand = 'Honda UK'; }
			if($brand == 'SJN')  { $brand = 'Nissan UK'; }
			if($brand == 'SKF')  { $brand = 'Vauxhall'; }
			if($brand == 'SLP')  { $brand = 'JCB Research UK'; }
			if($brand == 'SMT')  { $brand = 'Triumph Motorcycles'; }
			if($brand == 'SUF')  { $brand = 'Fiat Auto Poland'; }
			if($brand == 'SUL')  { $brand = 'FSC (Poland)'; }
			if($brand == 'SUP')  { $brand = 'FSO-Daewoo (Poland)'; }
			if($brand == 'SU9')  { $brand = 'Solaris Bus & Coach (Poland)'; }
			if($brand == 'SUU')  { $brand = 'Solaris Bus & Coach (Poland)'; }
			if($brand == 'SWV')  { $brand = 'TA-NO (Poland)'; }
			if($brand == 'TCC')  { $brand = 'Micro Compact Car AG (smart 1998-1999)'; }
			if($brand == 'TDM')  { $brand = 'QUANTYA Swiss Electric Movement (Switzerland)'; }
			if($brand == 'TK9')  { $brand = 'SOR buses (Czech Republic)'; }
			if($brand == 'TMA')  { $brand = 'Hyundai Motor Manufacturing Czech'; }
			if($brand == 'TMB')  { $brand = 'Škoda (Czech Republic)'; }
			if($brand == 'TMK')  { $brand = 'Karosa (Czech Republic)'; }
			if($brand == 'TMP')  { $brand = 'Škoda trolleybuses (Czech Republic)'; }
			if($brand == 'TMT')  { $brand = 'Tatra (Czech Republic)'; }
			if($brand == 'TM9')  { $brand = 'Škoda trolleybuses (Czech Republic)'; }
			if($brand == 'TNE')  { $brand = 'TAZ'; }
			if($brand == 'TN9')  { $brand = 'Karosa (Czech Republic)'; }
			if($brand == 'TRA')  { $brand = 'Ikarus Bus'; }
			if($brand == 'TRU')  { $brand = 'Audi Hungary'; }
			if($brand == 'TSB')  { $brand = 'Ikarus Bus'; }
			if($brand == 'TSE')  { $brand = 'Ikarus Egyedi Autobuszgyar, (Hungary)'; }
			if($brand == 'TSM')  { $brand = 'Suzuki Hungary'; }
			if($brand == 'TW1')  { $brand = 'Toyota Caetano Portugal'; }
			if($brand == 'TYA')  { $brand = 'Mitsubishi Trucks Portugal'; }
			if($brand == 'TYB')  { $brand = 'Mitsubishi Trucks Portugal'; }
			if($brand == 'UU1')  { $brand = 'Renault Dacia, (Romania)'; }
			if($brand == 'UU2')  { $brand = 'Oltcit'; }
			if($brand == 'UU3')  { $brand = 'ARO'; }
			if($brand == 'UU4')  { $brand = 'Roman SA'; }
			if($brand == 'UU5')  { $brand = 'Rocar'; }
			if($brand == 'UU6')  { $brand = 'Daewoo Romania'; }
			if($brand == 'UU7')  { $brand = 'Euro Bus Diamond'; }
			if($brand == 'UU9')  { $brand = 'Astra Bus'; }
			if($brand == 'UZT')  { $brand = 'UTB (Uzina de Tractoare Brașov)'; }
			if($brand == 'U5Y')  { $brand = 'Kia Motors Slovakia'; }
			if($brand == 'U6Y')  { $brand = 'Kia Motors Slovakia'; }
			if($brand == 'VAG')  { $brand = 'Magna Steyr Puch'; }
			if($brand == 'VAN')  { $brand = 'MAN Austria'; }
			if($brand == 'VBK')  { $brand = 'KTM (Motorcycles)'; }
			if($brand == 'VF1')  { $brand = 'Renault'; }
			if($brand == 'VF2')  { $brand = 'Renault'; }
			if($brand == 'VF3')  { $brand = 'Peugeot'; }
			if($brand == 'VF4')  { $brand = 'Talbot'; }
			if($brand == 'VF6')  { $brand = 'Renault (Trucks & Buses)'; }
			if($brand == 'VF7')  { $brand = 'Citroën'; }
			if($brand == 'VF8')  { $brand = 'Matra'; }
			if($brand == 'VF9')  { $brand = 'Bugatti'; }
			if($brand == '795')  { $brand = 'Bugatti'; }
			if($brand == 'VG5')  { $brand = 'MBK (motorcycles)'; }
			if($brand == 'VLU')  { $brand = 'Scania France'; }
			if($brand == 'VN1')  { $brand = 'SOVAB (France)'; }
			if($brand == 'VNE')  { $brand = 'Irisbus (France)'; }
			if($brand == 'VNK')  { $brand = 'Toyota France'; }
			if($brand == 'VNV')  { $brand = 'Renault-Nissan'; }
			if($brand == 'VSA')  { $brand = 'Mercedes-Benz Spain'; }
			if($brand == 'VSE')  { $brand = 'Suzuki Spain (Santana Motors)'; }
			if($brand == 'VSK')  { $brand = 'Nissan Spain'; }
			if($brand == 'VSS')  { $brand = 'SEAT'; }
			if($brand == 'VSX')  { $brand = 'Opel Spain'; }
			if($brand == 'VS6')  { $brand = 'Ford Spain'; }
			if($brand == 'VS7')  { $brand = 'Citroën Spain'; }
			if($brand == 'VS9')  { $brand = 'Carrocerias Ayats (Spain)'; }
			if($brand == 'VTH')  { $brand = 'Derbi (motorcycles)'; }
			if($brand == 'VTL')  { $brand = 'Yamaha Spain (motorcycles)'; }
			if($brand == 'VTT')  { $brand = 'Suzuki Spain (motorcycles)'; }
			if($brand == 'VV9')  { $brand = 'TAURO Spain'; }
			if($brand == 'VWA')  { $brand = 'Nissan Spain'; }
			if($brand == 'VWV')  { $brand = 'Volkswagen Spain'; }
			if($brand == 'VX1')  { $brand = 'Zastava / Yugo Serbia'; }
			if($brand == 'WAG')  { $brand = 'Neoplan'; }
			if($brand == 'WAU')  { $brand = 'Audi'; }
			if($brand == 'WA1')  { $brand = 'Audi SUV'; }
			if($brand == 'WBA')  { $brand = 'BMW'; }
			if($brand == 'WBS')  { $brand = 'BMW M'; }
			if($brand == 'WBW')  { $brand = 'BMW'; }
			if($brand == 'WBY')  { $brand = 'BMW'; }
			if($brand == 'WDA')  { $brand = 'Daimler'; }
			if($brand == 'WDB')  { $brand = 'Mercedes-Benz'; }
			if($brand == 'WDC')  { $brand = 'DaimlerChrysler'; }
			if($brand == 'WDD')  { $brand = 'Mercedes-Benz'; }
			if($brand == 'WDF')  { $brand = 'Mercedes-Benz (commercial vehicles)'; }
			if($brand == 'WEB')  { $brand = 'Evobus GmbH (Mercedes-Bus)'; }
			if($brand == 'WJM')  { $brand = 'Iveco Magirus'; }
			if($brand == 'WF0')  { $brand = 'Ford Germany'; }
			if($brand == 'WKE')  { $brand = 'Fahrzeugwerk Bernard Krone (truck trailers)'; }
			if($brand == 'WKK')  { $brand = 'Kässbohrer/Setra'; }
			if($brand == 'WMA')  { $brand = 'MAN Germany'; }
			if($brand == 'WME')  { $brand = 'smart'; }
			if($brand == 'WMW')  { $brand = 'MINI'; }
			if($brand == 'WMX')  { $brand = 'Mercedes-AMG'; }
			if($brand == 'WP0')  { $brand = 'Porsche'; }
			if($brand == 'WP1')  { $brand = 'Porsche SUV'; }
			if($brand == 'WSM')  { $brand = 'Schmitz-Cargobull (truck trailers)'; }
			if($brand == 'W09')  { $brand = 'RUF'; }
			if($brand == 'W0L')  { $brand = 'Opel'; }
			if($brand == 'W0V')  { $brand = 'Opel (since 2017)'; }
			if($brand == 'WUA')  { $brand = 'Audi Sport GmbH (formerly quattro GmbH)'; }
			if($brand == 'WVG')  { $brand = 'Volkswagen MPV/SUV'; }
			if($brand == 'WVW')  { $brand = 'Volkswagen'; }
			if($brand == 'WV1')  { $brand = 'Volkswagen Commercial Vehicles'; }
			if($brand == 'WV2')  { $brand = 'Volkswagen Bus/Van'; }
			if($brand == 'WV3')  { $brand = 'Volkswagen Trucks'; }
			if($brand == 'XLB')  { $brand = 'Volvo (NedCar)'; }
			if($brand == 'XLE')  { $brand = 'Scania Netherlands'; }
			if($brand == 'XLR')  { $brand = 'DAF (trucks)'; }
			if($brand == 'XL9')  { $brand = 'Spyker'; }
			if($brand == '363')  { $brand = 'Spyker'; }
			if($brand == 'XMC')  { $brand = 'Mitsubishi (NedCar)'; }
			if($brand == 'XMG')  { $brand = 'VDL Bus & Coach'; }
			if($brand == 'XTA')  { $brand = 'Lada/AvtoVAZ (Russia)'; }
			if($brand == 'XTC')  { $brand = 'KAMAZ (Russia)'; }
			if($brand == 'XTH')  { $brand = 'GAZ (Russia)'; }
			if($brand == 'XTT')  { $brand = 'UAZ/Sollers (Russia)'; }
			if($brand == 'XTU')  { $brand = 'Trolza (Russia)'; }
			if($brand == 'XTY')  { $brand = 'LiAZ (Russia)'; }
			if($brand == 'XUF')  { $brand = 'General Motors Russia'; }
			if($brand == 'XUU')  { $brand = 'AvtoTor (Russia, General Motors SKD)'; }
			if($brand == 'XW8')  { $brand = 'Volkswagen Group Russia'; }
			if($brand == 'XWB')  { $brand = 'UZ-Daewoo (Uzbekistan)'; }
			if($brand == 'XWE')  { $brand = 'AvtoTor (Russia, Hyundai-Kia SKD)'; }
			if($brand == 'X1M')  { $brand = 'PAZ (Russia)'; }
			if($brand == 'X4X')  { $brand = 'AvtoTor (Russia, BMW SKD)'; }
			if($brand == 'X7L')  { $brand = 'Renault AvtoFramos (Russia)'; }
			if($brand == 'X7M')  { $brand = 'Hyundai TagAZ (Russia)'; }
			if($brand == 'YBW')  { $brand = 'Volkswagen Belgium'; }
			if($brand == 'YB1')  { $brand = 'Volvo Trucks Belgium'; }
			if($brand == 'YCM')  { $brand = 'Mazda Belgium'; }
			if($brand == 'YE2')  { $brand = 'Van Hool (buses)'; }
			if($brand == 'YH2')  { $brand = 'BRP Finland (Lynx snowmobiles)'; }
			if($brand == 'YK1')  { $brand = 'Saab-Valmet Finland'; }
			if($brand == 'YSC')  { $brand = 'Cadillac (Saab)'; }
			if($brand == 'YS2')  { $brand = 'Scania AB'; }
			if($brand == 'YS3')  { $brand = 'Saab'; }
			if($brand == 'YS4')  { $brand = 'Scania Bus'; }
			if($brand == 'YTN')  { $brand = 'Saab NEVS'; }
			if($brand == 'YT9')  { $brand = 'Koenigsegg'; }
			if($brand == '007')  { $brand = 'Koenigsegg'; }
			if($brand == 'YT9')  { $brand = 'Carvia'; }
			if($brand == '034')  { $brand = 'Carvia'; }
			if($brand == 'YU7')  { $brand = 'Husaberg (motorcycles)'; }
			if($brand == 'YVV')  { $brand = 'Polestar (Volvo) (Sweden)'; }
			if($brand == 'YV1')  { $brand = 'Volvo Cars'; }
			if($brand == 'YV4')  { $brand = 'Volvo Cars'; }
			if($brand == 'YV2')  { $brand = 'Volvo Trucks'; }
			if($brand == 'YV3')  { $brand = 'Volvo Buses'; }
			if($brand == 'Y3M')  { $brand = 'MAZ (Belarus)'; }
			if($brand == 'Y6D')  { $brand = 'Zaporozhets/AvtoZAZ (Ukraine)'; }
			if($brand == 'ZAA')  { $brand = 'Autobianchi'; }
			if($brand == 'ZAM')  { $brand = 'Maserati'; }
			if($brand == 'ZAP')  { $brand = 'Piaggio/Vespa/Gilera'; }
			if($brand == 'ZAR')  { $brand = 'Alfa Romeo'; }
			if($brand == 'ZBN')  { $brand = 'Benelli'; }
			if($brand == 'ZCG')  { $brand = 'Cagiva SpA / MV Agusta'; }
			if($brand == 'ZCF')  { $brand = 'Iveco'; }
			if($brand == 'ZDC')  { $brand = 'Honda Italia Industriale SpA'; }
			if($brand == 'ZDM')  { $brand = 'Ducati Motor Holdings SpA'; }
			if($brand == 'ZDF')  { $brand = 'Ferrari Dino'; }
			if($brand == 'ZD0')  { $brand = 'Yamaha Italy'; }
			if($brand == 'ZD3')  { $brand = 'Beta Motor'; }
			if($brand == 'ZD4')  { $brand = 'Aprilia'; }
			if($brand == 'ZFA')  { $brand = 'Fiat'; }
			if($brand == 'ZFC')  { $brand = 'Fiat V.I.'; }
			if($brand == 'ZFF')  { $brand = 'Ferrari'; }
			if($brand == 'ZGU')  { $brand = 'Moto Guzzi'; }
			if($brand == 'ZHW')  { $brand = 'Lamborghini'; }
			if($brand == 'ZJM')  { $brand = 'Malaguti'; }
			if($brand == 'ZJN')  { $brand = 'Innocenti'; }
			if($brand == 'ZKH')  { $brand = 'Husqvarna Motorcycles Italy'; }
			if($brand == 'ZLA')  { $brand = 'Lancia'; }
			if($brand == 'Z8M')  { $brand = 'Marussia (Russia)'; }
			if($brand == '1B3')  { $brand = 'Dodge'; }
			if($brand == '1C3')  { $brand = 'Chrysler'; }
			if($brand == '1C4')  { $brand = 'Chrysler'; }
			if($brand == '1C6')  { $brand = 'Chrysler'; }
			if($brand == '1D3')  { $brand = 'Dodge'; }
			if($brand == '1FA')  { $brand = 'Ford Motor Company'; }
			if($brand == '1FB')  { $brand = 'Ford Motor Company'; }
			if($brand == '1FC')  { $brand = 'Ford Motor Company'; }
			if($brand == '1FD')  { $brand = 'Ford Motor Company'; }
			if($brand == '1FM')  { $brand = 'Ford Motor Company'; }
			if($brand == '1FT')  { $brand = 'Ford Motor Company'; }
			if($brand == '1FU')  { $brand = 'Freightliner'; }
			if($brand == '1FV')  { $brand = 'Freightliner'; }
			if($brand == '1F9')  { $brand = 'FWD Corp.'; }
			if($brand == '1GC')  { $brand = 'Chevrolet Truck USA'; }
			if($brand == '1GT')  { $brand = 'GMC Truck USA'; }
			if($brand == '1G1')  { $brand = 'Chevrolet USA'; }
			if($brand == '1G2')  { $brand = 'Pontiac USA'; }
			if($brand == '1G3')  { $brand = 'Oldsmobile USA'; }
			if($brand == '1G4')  { $brand = 'Buick USA'; }
			if($brand == '1G6')  { $brand = 'Cadillac USA'; }
			if($brand == '1G8')  { $brand = 'Saturn USA'; }
			if($brand == '1GM')  { $brand = 'Pontiac USA'; }
			if($brand == '1GY')  { $brand = 'Cadillac USA'; }
			if($brand == '1HD')  { $brand = 'Harley-Davidson'; }
			if($brand == '1HT')  { $brand = 'International Truck and Engine Corp. USA'; }
			if($brand == '1J4')  { $brand = 'Jeep'; }
			if($brand == '1J8')  { $brand = 'Jeep'; }
			
			if($brand == '1ME')  { $brand = 'Mercury USA'; }
			if($brand == '1M1')  { $brand = 'Mack Truck USA'; }
			if($brand == '1M2')  { $brand = 'Mack Truck USA'; }
			if($brand == '1M3')  { $brand = 'Mack Truck USA'; }
			if($brand == '1M4')  { $brand = 'Mack Truck USA'; }
			if($brand == '1M9')  { $brand = 'Mynatt Truck & Equipment'; }
			if($brand == '1NX')  { $brand = 'NUMMI USA'; }
			if($brand == '1P3')  { $brand = 'Plymouth USA'; }
			if($brand == '1PY')  { $brand = 'John Deere USA'; }
			if($brand == '1R9')  { $brand = 'Roadrunner Hay Squeeze USA'; }
			if($brand == '1VW')  { $brand = 'Volkswagen USA'; }
			if($brand == '1XK')  { $brand = 'Kenworth USA'; }
			if($brand == '1XP')  { $brand = 'Peterbilt USA'; }
			if($brand == '1YV')  { $brand = 'Mazda USA (AutoAlliance International)'; }
			if($brand == '1ZV')  { $brand = 'Ford (AutoAlliance International)'; }
			if($brand == '2A4')  { $brand = 'Chrysler Canada'; }
			if($brand == '2BP')  { $brand = 'Bombardier Recreational Products'; }
			if($brand == '2B3')  { $brand = 'Dodge Canada'; }
			if($brand == '2B7')  { $brand = 'Dodge Canada'; }
			if($brand == '2C3')  { $brand = 'Chrysler Canada'; }
			if($brand == '2CN')  { $brand = 'CAMI'; }
			if($brand == '2D3')  { $brand = 'Dodge Canada'; }
			if($brand == '2FA')  { $brand = 'Ford Motor Company Canada'; }
			if($brand == '2FB')  { $brand = 'Ford Motor Company Canada'; }
			if($brand == '2FC')  { $brand = 'Ford Motor Company Canada'; }
			if($brand == '2FM')  { $brand = 'Ford Motor Company Canada'; }
			if($brand == '2FT')  { $brand = 'Ford Motor Company Canada'; }
			if($brand == '2FU')  { $brand = 'Freightliner'; }
			if($brand == '2FV')  { $brand = 'Freightliner'; }
			if($brand == '2FZ')  { $brand = 'Sterling'; }
			if($brand == '2Gx')  { $brand = 'General Motors Canada'; }
			if($brand == '2G1')  { $brand = 'Chevrolet Canada'; }
			if($brand == '2G2')  { $brand = 'Pontiac Canada'; }
			if($brand == '2G3')  { $brand = 'Oldsmobile Canada'; }
			if($brand == '2G4')  { $brand = 'Buick Canada'; }
			if($brand == '2G9')  { $brand = 'mfr. of less than 1000/ yr. Canada'; }
			if($brand == '2HG')  { $brand = 'Honda Canada'; }
			if($brand == '2HK')  { $brand = 'Honda Canada'; }
			if($brand == '2HJ')  { $brand = 'Honda Canada'; }
			if($brand == '2HM')  { $brand = 'Hyundai Canada'; }
			if($brand == '2NV')  { $brand = 'Nova Bus Canada'; }
			if($brand == '2P3')  { $brand = 'Plymouth Canada'; }
			if($brand == '2TP')  { $brand = 'Triple E Canada LTD'; }
			if($brand == '2V4')  { $brand = 'Volkswagen Canada'; }
			if($brand == '2V8')  { $brand = 'Volkswagen Canada'; }
			if($brand == '2WK')  { $brand = 'Western Star'; }
			if($brand == '2WL')  { $brand = 'Western Star'; }
			if($brand == '2WM')  { $brand = 'Western Star'; }
			if($brand == '3C4')  { $brand = 'Chrysler Mexico'; }
			if($brand == '3C6')  { $brand = 'RAM Mexico'; }
			if($brand == '3D3')  { $brand = 'Dodge Mexico'; }
			if($brand == '3D4')  { $brand = 'Dodge Mexico'; }
			if($brand == '3FA')  { $brand = 'Ford Motor Company Mexico'; }
			if($brand == '3FE')  { $brand = 'Ford Motor Company Mexico'; }
			if($brand == '3JB')  { $brand = 'BRP Mexico (all-terrain vehicles)'; }
			if($brand == '3MD')  { $brand = 'Mazda Mexico'; }
			if($brand == '3MZ')  { $brand = 'Mazda Mexico'; }
			if($brand == '3NS')  { $brand = 'Polaris Industries USA'; }
			if($brand == '3NE')  { $brand = 'Polaris Industries USA'; }
			if($brand == '3P3')  { $brand = 'Plymouth Mexico'; }
			if($brand == '3VW')  { $brand = 'Volkswagen Mexico'; }
			if($brand == '46J')  { $brand = 'Federal Motors Inc. USA'; }
			if($brand == '4EN')  { $brand = 'Emergency One USA'; }
			
			
			
			if($brand == '4JG')  { $brand = 'Mercedes-Benz USA'; }
			if($brand == '4M')  { $brand = 'Mercury'; }
			if($brand == '4P1')  { $brand = 'Pierce Manufacturing Inc. USA'; }
			if($brand == '4RK')  { $brand = 'Nova Bus USA'; }
			if($brand == '4T9')  { $brand = 'Lumen Motors'; }
			if($brand == '4UF')  { $brand = 'Arctic Cat Inc.'; }
			if($brand == '4US')  { $brand = 'BMW USA'; }
			if($brand == '4UZ')  { $brand = 'Frt-Thomas Bus'; }
			if($brand == '4V1')  { $brand = 'Volvo'; }
			if($brand == '4V2')  { $brand = 'Volvo'; }
			if($brand == '4V3')  { $brand = 'Volvo'; }
			if($brand == '4V4')  { $brand = 'Volvo'; }
			if($brand == '4V5')  { $brand = 'Volvo'; }
			if($brand == '4V6')  { $brand = 'Volvo'; }
			if($brand == '4VL')  { $brand = 'Volvo'; }
			if($brand == '4VM')  { $brand = 'Volvo'; }
			if($brand == '4VZ')  { $brand = 'Volvo'; }
			if($brand == '538')  { $brand = 'Zero Motorcycles (USA)'; }
			if($brand == '5N1')  { $brand = 'Nissan USA'; }
			if($brand == '5NP')  { $brand = 'Hyundai USA'; }
			
			if($brand == '5YJ')  { $brand = 'Tesla, Inc.'; }
			if($brand == '56K')  { $brand = 'Indian Motorcycle USA'; }
			if($brand == '6AB')  { $brand = 'MAN Australia'; }
			if($brand == '6F4')  { $brand = 'Nissan Motor Company Australia'; }
			if($brand == '6F5')  { $brand = 'Kenworth Australia'; }
			if($brand == '6FP')  { $brand = 'Ford Motor Company Australia'; }
			if($brand == '6G1')  { $brand = 'General Motors-Holden (post Nov 2002)'; }
			if($brand == '6G2')  { $brand = 'Pontiac Australia (GTO & G8)'; }
			if($brand == '6H8')  { $brand = 'General Motors-Holden (pre Nov 2002)'; }
			if($brand == '6MM')  { $brand = 'Mitsubishi Motors Australia'; }
			if($brand == '6T1')  { $brand = 'Toyota Motor Corporation Australia'; }
			if($brand == '6U9')  { $brand = 'Privately Imported car in Australia'; }
			if($brand == '8AD')  { $brand = 'Peugeot Argentina'; }
			if($brand == '8AF')  { $brand = 'Ford Motor Company Argentina'; }
			if($brand == '8AG')  { $brand = 'Chevrolet Argentina'; }
			if($brand == '8AJ')  { $brand = 'Toyota Argentina'; }
			if($brand == '8AK')  { $brand = 'Suzuki Argentina'; }
			if($brand == '8AP')  { $brand = 'Fiat Argentina'; }
			if($brand == '8AW')  { $brand = 'Volkswagen Argentina'; }
			if($brand == '8A1')  { $brand = 'Renault Argentina'; }
			if($brand == '8GD')  { $brand = 'Peugeot Chile'; }
			if($brand == '8GG')  { $brand = 'Chevrolet Chile'; }
			if($brand == '8LD')  { $brand = 'Chevrolet Ecuador'; }
			if($brand == '935')  { $brand = 'Citroën Brazil'; }
			if($brand == '936')  { $brand = 'Peugeot Brazil'; }
			if($brand == '93H')  { $brand = 'Honda Brazil'; }
			if($brand == '93R')  { $brand = 'Toyota Brazil'; }
			if($brand == '93U')  { $brand = 'Audi Brazil'; }
			if($brand == '93V')  { $brand = 'Audi Brazil'; }
			if($brand == '93X')  { $brand = 'Mitsubishi Motors Brazil'; }
			if($brand == '93Y')  { $brand = 'Renault Brazil'; }
			if($brand == '94D')  { $brand = 'Nissan Brazil'; }
			if($brand == '9BF')  { $brand = 'Ford Motor Company Brazil'; }
			if($brand == '9BG')  { $brand = 'Chevrolet Brazil'; }
			if($brand == '9BM')  { $brand = 'Mercedes-Benz Brazil'; }
			if($brand == '9BR')  { $brand = 'Toyota Brazil'; }
			if($brand == '9BS')  { $brand = 'Scania Brazil'; }
			if($brand == '9BW')  { $brand = 'Volkswagen Brazil'; }
			if($brand == '9FB')  { $brand = 'Renault Colombia'; }
			if($brand == 'WB1')  { $brand = 'BMW Motorrad of North America'; }
		
		
		return "$brand";
		
		return "";
	}

	/**
	* Detect vehicle production year
	*
	* @param None
	* @return int $year
	* @throws InvalidYearException, DecodedYearMismatch
	*/
	public function year() : int {
		return 0;
	}


	/**
	* Return the last characters of the VIN
	* (From character 17 to index)
	* (Default to 8)
	*
	* @param None|int $length
	* @return string $last
	* @throws None
	*/
	public function last(int $length = 8) : string {
		// Checks
		if ($length > strlen($this->VIN)) {
			$length = 8;
		}

		// Return
		return substr($this->VIN, strlen($this->VIN) - $length, strlen($this->VIN));
	}

	/**
	* Validate VIN characters
	*
	* @param string $vin
	* @return bool valid
	* @throws TypeError
	*/
	protected function validate(string $vin) : bool {
		// Variables
		$valid = true;

		// Loops
		for ($i = 0; $i < strlen($vin); $i++) {
			if (strpos($this->_Characters, strtoupper($vin[$i])) !== false) {
				continue;
			} else {
				$valid = false;
				break;
			}
		}

		// Return
		return $valid;
	}
}

// Vehicle Identification Number WMI
class WMI {
	// Class Variables
	protected $country;
	protected $region;
	protected $low;
	protected $high;
	protected $Characters = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";

	/**
	* Class constructor
	*
	* @param string $vin
	* @return None
	* @throws None
	**/
	public function __construct($country = "", $region = "", $low = "", $high = "") {
		// Variables
		$this->country = $country;
		$this->region = $region;
		$this->low = $low;
		$this->high = $high;
	}

	/**
	* Class stringify method
	*
	* @param None
	* @return string WMI Country, Region (Low, High)
	* @throws None
	**/
	public function __tostring() : string {
		return sprintf("%s, %s (%s, %s)", $this->country, $this->region, $this->low, $this->high);
	}

	private static function CodeToDec($code) {
		// Checks
		if (strlen($code) != 2) {
			return false;
		}

		// Return
		return (strpos($this->Characters, $code{0}) * strlen($this->Characters)) + strpos($this->Characters, $code{1});
	}

	public function match($vin) : boolean {
		$code = substr($vin,0,2);
		$_low = WMI::CodeToDec($this->low);
		$_high = WMI::CodeToDec($this->high);
		$_code = WMI::CodeToDec($code);

		return (($_code >= $_low) && ($_code <= $_high));
	}
}
?>
