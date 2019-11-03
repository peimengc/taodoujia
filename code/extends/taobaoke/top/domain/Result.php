<?php

/**
 * 处罚订单列表
 * @author auto create
 */
class Result
{
	
	/** 
	 * 处罚状态，0 正常，1待处罚，2冻结
	 **/
	public $punish_status;
	
	/** 
	 * 渠道关系id
	 **/
	public $relation_id;
	
	/** 
	 * 结算月份
	 **/
	public $settle_month;
	
	/** 
	 * 会员运营id
	 **/
	public $special_id;
	
	/** 
	 * 子订单号
	 **/
	public $tb_trade_id;
	
	/** 
	 * 父订单号
	 **/
	public $tb_trade_parent_id;
	
	/** 
	 * pid里的adzoneid
	 **/
	public $tk_adzone_id;
	
	/** 
	 * pid里的pubid
	 **/
	public $tk_pub_id;
	
	/** 
	 * pid里的siteid
	 **/
	public $tk_site_id;
	
	/** 
	 * 淘客订单创建时间
	 **/
	public $tk_trade_create_time;
	
	/** 
	 * 淘宝联盟unionid
	 **/
	public $union_id;
	
	/** 
	 * 处罚类型，1 店铺淘客，2其他
	 **/
	public $violation_type;	
}
?>