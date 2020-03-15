## E-mall system
This is a simple course design (*E-commerce* by Associate Prof. Jianlan Zhou) that basically achieve some functions both for customers and sellers.

Develop Environment: Use **xampp** to utilize the scripts and **navicat8** for the database.

基本功能说明：
① 登陆注册
检测ID重复
买家卖家个性化（具体在后面会说明）
② 新增商品
买家新增商品只能添加两种信息，因为和银行建立了接口，所以库存需要在加货功能实现，在这里演示是说明我可以实现添加商品功能
③ 付款
可以在生成订单之后直接付款，也可以在我的订单页面中点击付款
③ 库存失效
一分钟的有效时间
④ 用户信息修改
商家利润是没办法修改的，这是通过后台计算得到
⑤ 撤销订单
删除的话如果是ispay=0即还未付款的商品库存会增加，ispay=1/2即已付款/失效的库存不会增加
⑥ 支付订单
第二种付款方式，密码输错了无法支付
⑦ 库存管理
添加商品不能选择库存是因为商家进购商品是要花钱的，所以必须在加货地方增加库存，然后这里增加库存是用一开始定的价格即采购价格加的库存，然后通过修改商品价格来卖给买家，这样可以赚取收益。修改过的价格不影响进价。
此外，关于银行接口，商家在进购商品时的总数量不能大于自己的存款，如果大于存款则加货失败；还有在加购商品之后利润和存款都会减去响应的数值；
⑧ 物流配送建立接口
三次握手，对于成功支付的订单才会在卖家端显示发货
⑨ 银行接口
存款管理
利润计算

